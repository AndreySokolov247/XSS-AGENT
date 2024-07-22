# Use the Python 3.11 slim base image
FROM python:3.11-slim

# Set the working directory in the container
WORKDIR /work_directory

# Install necessary dependencies
RUN apt-get update && apt-get install -y \
    curl \
    gnupg \
    htop \
    software-properties-common \
    && rm -rf /var/lib/apt/lists/*

# Install NVIDIA Container Toolkit
RUN curl -fsSL https://nvidia.github.io/libnvidia-container/gpgkey | gpg --dearmor -o /usr/share/keyrings/nvidia-container-toolkit-keyring.gpg \
    && curl -s -L https://nvidia.github.io/libnvidia-container/stable/deb/nvidia-container-toolkit.list | sed 's#deb https://#deb [signed-by=/usr/share/keyrings/nvidia-container-toolkit-keyring.gpg] https://#g' | tee /etc/apt/sources.list.d/nvidia-container-toolkit.list \
    && apt-get update \
    && apt-get install -y nvidia-container-toolkit \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install Ollama using the provided script
RUN curl -fsSL https://ollama.com/install.sh | sh

# Copy the local files recon_agent.py and requirements.txt to the working directory in the container
COPY ./work_agents/ /work_directory/
COPY ./work_agents/dependencies/requirements.txt /work_directory/dependencies/requirements.txt

# Install Python dependencies from requirements file
RUN pip install --upgrade pip setuptools wheel \
    && pip install -r /work_directory/dependencies/requirements.txt

# Start Ollama server and pull model
CMD ollama serve & \
    until curl -s http://localhost:11434 >/dev/null; do \
        echo "Waiting for Ollama server to be ready..."; \
        sleep 1; \
    done; \
    ollama pull dolphin-llama3:8b && \
    python /work_directory/agent_controller.py
    







    