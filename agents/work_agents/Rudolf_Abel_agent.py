from crewai import Agent, Task, Crew, Process
from langchain_community.llms import Ollama

def run_rudolf_agent():
    # Instantiate the Ollama model
    model = Ollama(model="dolphin-llama3:8b")

    # Define the Rudolf Abel agent for reconnaissance and cleaning
    Rudolf_Abel_agent = Agent(
        role='Windows Post-Exploitation Reconnaissance Specialist',
        goal='Generate and clean a single executable command for initial reconnaissance on a Windows host',
        backstory=f"""You are Rudolf Abel, a specialist in post-exploitation reconnaissance within Windows corporate networks.
        Your objective is to generate and refine native Windows commands for execution on a host to collect
        detailed internal network information, system details, and domain user enumeration.

        Key Points:
        - Each command must be unique and not duplicate previous commands.
        - Each command must have the correct syntax for Windows CMD.
        - Each command must be executable and relevant to Windows OS enumeration.
        - Ensure the command is clean and without any additional text or formatting.
        
        Your task is to generate a single executable command that is clear, effective, and correctly formatted.
        If a command has already been generated, choose another unique command. Return only the command with no additional text.
        """,
        verbose=True,
        allow_delegation=False,
        llm=model,
    )

    # Task for the Rudolf Abel agent to generate and clean a single command
    recon_task = Task(
        description="Generate a single executable command for initial reconnaissance on a Windows host. The output must be a clean command with no additional text.",
        agent=Rudolf_Abel_agent,
        expected_output="command"
    )

    # Create the crew with the defined agent and task
    crew = Crew(
        agents=[Rudolf_Abel_agent],
        tasks=[recon_task],
        process=Process.sequential,
        memory=True, 
        verbose=True,  
        embedder={
            "provider": "ollama",
            "config": {
                "model": 'chroma/all-minilm-l6-v2-f32:latest',
            }
        },\
    )
    
    # Run the process and return the result
    result = crew.kickoff()
    return result