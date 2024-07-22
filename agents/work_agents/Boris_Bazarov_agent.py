from crewai import Agent, Task, Crew, Process
from langchain_community.llms import Ollama

def run_boris_agent(operation_data):
    # Instantiate the Ollama model
    model = Ollama(model="dolphin-llama3:8b")

    # Define the Boris Bazarov agent for intelligence reporting
    Boris_Bazarov_agent = Agent(
        role='Intelligence Officer',
        goal='Create detailed reports summarizing key points of reconnaissance operations',
        backstory=f"""As an Intelligence Officer, your role is to compile and analyze the provided reconnaissance data: 
        {operation_data}

        Your objective is to create a comprehensive report that highlights critical insights and strategic recommendations based on this information.

        Output Format:
        The report should include:
        - Executive Summary: A concise overview of the key points and recommendations.
        - Key Findings: A detailed analysis of the most significant data points and their implications.
        - Relevant Insights: Additional context and interpretations that provide depth to the findings.
        - Actionable Recommendations: Clear and specific suggestions for decision-makers to consider.

        Your task is to ensure that the report is thorough, accurate, and directly relevant to the reconnaissance data provided. Focus on clarity and actionable insights to guide decision-making.
        """,
        verbose=True,
        allow_delegation=False,
        llm=model,
    )

    # Task for the Boris Bazarov agent to create intelligence reports
    reporting_task = Task(
        description="Compile and analyze the provided reconnaissance data to create a detailed intelligence report.",
        agent=Boris_Bazarov_agent,
        expected_input=operation_data, 
        expected_output="A comprehensive intelligence report with key findings and recommendations based solely on the provided reconnaissance data."
    )

    # Create the crew with the defined agent and task, enabling memory with local embeddings
    crew = Crew(
        agents=[Boris_Bazarov_agent],
        tasks=[reporting_task],
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

    # Start the crew's process
    result = crew.kickoff()

    return result  # Return the result for further use

# Example of how to call the function
if __name__ == "__main__":
    reconnaissance_data = "Multiple user accounts with administrative privileges detected. These accounts may pose a security risk and should be reviewed. Mitigating access for these accounts will enhance the overall security posture."
    intelligence_report = run_boris_agent(reconnaissance_data)
    print(intelligence_report)