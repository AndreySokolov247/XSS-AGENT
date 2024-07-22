# Import necessary libraries
import requests
from crewai import Agent, Task, Crew, Process
from langchain_community.llms import Ollama

def run_iskhak_agent(recon_data):
    # Define the Iskhak Akhmerov agent, including reconnaissance data in the backstory
    model = Ollama(model="dolphin-llama3:8b")

    # Define the Iskhak Akhmerov agent
    Iskhak_Akhmerov_agent = Agent(
        role='Data Analysis Specialist',
        goal='Process and analyze collected reconnaissance data to highlight the most relevant insights from an attacker’s perspective.',
        backstory=f"""You are Iskhak Akhmerov, a highly skilled Data Analysis Specialist with extensive experience in analyzing reconnaissance data within operational environments. 
            Your mission is to examine the provided reconnaissance data thoroughly, identifying the most critical insights that can impact operational strategies.

            The reconnaissance data you need to analyze is as follows:
            {recon_data}

            Your responsibilities include:
            - Analyzing the data to extract the most valuable information from an attacker's perspective.
            - Highlighting key details such as user credentials, network configurations, and other sensitive information that could be of interest.
            - Providing clear explanations for why each highlighted piece of information is significant and valuable.
            - Summarizing your findings concisely, ensuring each insight is relevant and actionable.

            Your outputs must prioritize clarity and relevance, focusing on delivering actionable intelligence that can inform decision-making processes.
            """,
        verbose=True,
        allow_delegation=False,
        llm=model,
    )

    # Define the analysis task
    analysis_task = Task(
        description="Analyze the provided reconnaissance data and highlight the most relevant insights from an attacker's perspective.",
        agent=Iskhak_Akhmerov_agent,
        expected_input="Reconnaissance data provided directly in the backstory.",
        expected_output="Highlighted insights with explanations of their importance from an attacker's perspective."
    )

    # Configure the crew and process
    crew = Crew(
        agents=[Iskhak_Akhmerov_agent],
        tasks=[analysis_task],
        process=Process.sequential,
        memory=True, 
        verbose=True,  
        embedder={
            "provider": "ollama",
            "config": {
                "model": 'chroma/all-minilm-l6-v2-f32:latest',
            }
        },
    )

    # Run the process and return the result
    result = crew.kickoff()
    return result