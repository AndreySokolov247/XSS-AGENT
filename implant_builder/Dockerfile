# Use the Debian Bullseye base image
FROM debian:bullseye

# Set environment variables for Rust
ENV RUSTUP_HOME=/usr/local/rustup \
    CARGO_HOME=/usr/local/cargo \
    PATH=/usr/local/cargo/bin:/root/.cargo/bin:$PATH

# Install required dependencies
RUN apt-get update && apt-get install -y --no-install-recommends \
    build-essential \
    curl \
    gcc-mingw-w64-x86-64 \
    gcc-mingw-w64-i686 \
    ca-certificates \
    pkg-config \
    libssl-dev \
    && rm -rf /var/lib/apt/lists/*

# Install Rustup (Rust toolchain installer)
RUN curl https://sh.rustup.rs -sSf | sh -s -- -y

# Install the stable toolchain and necessary targets for cross-compilation
RUN rustup toolchain install stable \
    && rustup target add x86_64-pc-windows-gnu \
    && rustup target add i686-pc-windows-gnu

# Set environment variables for OpenSSL
ENV OPENSSL_DIR=/usr \
    OPENSSL_INCLUDE_DIR=/usr/include \
    OPENSSL_LIB_DIR=/usr/lib/x86_64-linux-gnu

# Set work directory
WORKDIR /implant

# Copy the source code into the container
COPY ./implant_source/ /implant/

# Start the application builder_manager
CMD ["/implant/builder_manager/target/release/builder_manager"]

#       Commands to compile for x86 and x64
# => cargo build --release --target x86_64-pc-windows-gnu
# => cargo build --release --target i686-pc-windows-gnu