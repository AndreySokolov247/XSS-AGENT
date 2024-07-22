<?php
include "settings.php";

  // Prepare and execute the SQL statement for fetching bot data
  $sql_bots = "SELECT id, name, ip_address, process_name, status FROM bots";
  $stmt_bots = $conn->prepare($sql_bots);
  $stmt_bots->execute();
  $result_bots = $stmt_bots->get_result();

  // Fetch data and generate table rows
  $rows_bots = '';
  while ($row = $result_bots->fetch_assoc()) {
      // Determine the badge color based on the bot's status
      $badge_color = '';
      switch ($row['status']) {
          case 'alive':
              $badge_color = 'success';
              break;
          case 'dormant':
              $badge_color = 'warning';
              break;
          case 'dead':
              $badge_color = 'danger';
              break;
          default:
              $badge_color = 'secondary';
      }

      $rows_bots .= '<tr>
                      <td class="w-10px align-middle">
                        <div class="form-check">
                          <input type="checkbox" class="form-check-input" id="bot' . $row['id'] . '">
                          <label class="form-check-label" for="bot' . $row['id'] . '"></label>
                        </div>
                      </td>
                      <td class="align-middle"><a href="">' . htmlspecialchars($row['id']) . '</a></td>
                      <td class="align-middle">' . htmlspecialchars($row['name']) . '</td>
                      <td class="align-middle">' . htmlspecialchars($row['ip_address']) . '</td>
                      <td class="align-middle">' . htmlspecialchars($row['process_name']) . '</td>
                      <td class="py-1 align-middle">
                        <span class="badge border border-' . $badge_color . ' text-' . $badge_color . ' px-2 pt-5px pb-5px rounded fs-12px d-inline-flex align-items-center">
                          <i class="fa fa-circle fs-9px fa-fw me-5px"></i> ' . htmlspecialchars($row['status']) . ' </span>
                      </td>
                    </tr>';
  }

  $stmt_bots->close();

//____________________________________________________________________________________________________________________




// Prepare and execute the SQL statement for fetching agent data
$sql_agents = "SELECT id, name, role, goal, backstory, agent_img FROM agents";
$stmt_agents = $conn->prepare($sql_agents);
$stmt_agents->execute();
$result_agents = $stmt_agents->get_result();

// Initialize the variable to hold agent cards content
$agent_cards_content = '';

// Generate tab structure
$agent_tabs = '<ul class="nav nav-tabs nav-tabs-v2 px-4" role="tablist">';
$active = true; // For setting the active class

while ($row = $result_agents->fetch_assoc()) {
    $active_class = $active ? 'active' : '';
    $icon = ''; // Removed the default icon

    // Set icon based on the agent's id
    switch ($row['id']) {
        case 1:
            $icon = 'bi bi-incognito';
            break;
        case 2:
            $icon = 'bi bi-bar-chart-line';
            break;
        case 3:
            $icon = 'bi bi-clipboard-data-fill';
            break;
        default:
            $icon = 'bi bi-person'; // Default icon for unspecified cases
    }

    $agent_tabs .= '<li class="nav-item me-3" role="presentation">
                    <a href="#' . strtolower(str_replace(' ', '-', $row['name'])) . '" class="nav-link px-2 ' . $active_class . '" data-bs-toggle="tab" aria-selected="' . ($active ? 'true' : 'false') . '" role="tab">
                        <i class="' . $icon . '"></i> ' . htmlspecialchars($row['name']) . '
                    </a>
                    </li>';
    $active = false; // Next tabs will not be active
}
$agent_tabs .= '</ul>';

// Generate tab content
$agent_tab_content = '<div class="tab-content p-4">';
$active = true; // Reset for tab content

$result_agents->data_seek(0); // Reset result pointer
while ($row = $result_agents->fetch_assoc()) {
    $active_class = $active ? 'show active' : 'fade';

    $agent_tab_content .= '<div class="tab-pane ' . $active_class . '" id="' . strtolower(str_replace(' ', '-', $row['name'])) . '" role="tabpanel">
                            <div class="card mb-3 border">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <img src="' . htmlspecialchars($row['agent_img']) . '" class="img-fluid rounded-circle me-3" alt="' . htmlspecialchars($row['name']) . '" style="width: 80px; height: 80px;">
                                        <h4 class="mb-0">' . htmlspecialchars($row['name']) . '</h4>
                                    </div>
                                    <div style="margin-top: 10px;">
                                    <div id="general" class="mb-5">
                                        <div class="card border-theme mb-3">
                                            <div class="card-header border-theme text-theme fw-bold small"><i class="bi bi-card-checklist"></i> Role</div>
                                            <div class="card-body">
                                                <p class="text-theme text-opacity-75">' . nl2br(htmlspecialchars($row['role'])) . '</p>
                                            </div>
                                            <div class="card-arrow">
                                                <div class="card-arrow-top-left"></div>
                                                <div class="card-arrow-top-right"></div>
                                                <div class="card-arrow-bottom-left"></div>
                                                <div class="card-arrow-bottom-right"></div>
                                            </div>
                                        </div>
                                        <div class="card border-theme mb-3">
                                            <div class="card-header border-theme text-theme fw-bold small"><i class="bi bi-layout-text-sidebar"></i> Goal</div>
                                            <div class="card-body">
                                                <p class="text-theme text-opacity-75">' . nl2br(htmlspecialchars($row['goal'])) . '</p>
                                            </div>
                                            <div class="card-arrow">
                                                <div class="card-arrow-top-left"></div>
                                                <div class="card-arrow-top-right"></div>
                                                <div class="card-arrow-bottom-left"></div>
                                                <div class="card-arrow-bottom-right"></div>
                                            </div>
                                        </div>
                                        <div class="card border-theme mb-3">
                                            <div class="card-header border-theme text-theme fw-bold small"><i class="bi bi-book"></i> Backstory</div>
                                            <div class="card-body">
                                                <p class="text-theme text-opacity-75">' . nl2br(htmlspecialchars($row['backstory'])) . '</p>
                                            </div>
                                            <div class="card-arrow">
                                                <div class="card-arrow-top-left"></div>
                                                <div class="card-arrow-top-right"></div>
                                                <div class="card-arrow-bottom-left"></div>
                                                <div class="card-arrow-bottom-right"></div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>';
    $active = false; // Next content will not be active
}
$agent_tab_content .= '</div>';

// Combine tabs and content into a single variable
$agent_cards_content = '<div class="card">' . $agent_tabs . $agent_tab_content . '</div>';

// Close the statement
$stmt_agents->close();

//______________________________________________________________________________________________________________________


// Prepare and execute the SQL statement for fetching log data
$sql_logs = "SELECT id, date, agent, bot, content FROM logs";
$stmt_logs = $conn->prepare($sql_logs);
$stmt_logs->execute();
$result_logs = $stmt_logs->get_result();

// Fetch data and generate table rows
$rows_logs = '';
while ($row = $result_logs->fetch_assoc()) {
    $rows_logs .= '<tr>
                    <td class="w-10px align-middle">
                      <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="log' . $row['id'] . '">
                        <label class="form-check-label" for="log' . $row['id'] . '"></label>
                      </div>
                    </td>
                    <td class="align-middle"><a href="#">' . htmlspecialchars($row['id']) . '</a></td>
                    <td class="align-middle">' . htmlspecialchars($row['date']) . '</td>
                    <td class="align-middle">' . htmlspecialchars($row['agent']) . '</td>
                    <td class="align-middle">' . htmlspecialchars($row['bot']) . '</td>
                    <td class="align-middle">' . htmlspecialchars($row['content']) . '</td>
                  </tr>';
}

$stmt_logs->close();



//______________________________________________________________________________________________________________________


// Prepare and execute the SQL statement for fetching report data
$sql_reports = "SELECT id, report_id, bot_name, date, content FROM report";
$stmt_reports = $conn->prepare($sql_reports);
$stmt_reports->execute();
$result_reports = $stmt_reports->get_result();

// Fetch data and generate HTML content
$html_content = '';
while ($row = $result_reports->fetch_assoc()) {
    $html_content .= '
    <div class="col-xl-12 col-lg-6">
        <div class="card mb-3">
            <div class="card-header d-flex align-items-center bg-inverse bg-opacity-10">
                <span class="flex-grow-1 fw-400">' . htmlspecialchars($row['report_id']) . '</span>
                <a href="#" class="text-inverse text-opacity-25 text-decoration-none me-3" disabled>
                    <i class="fa fa-fw fa-download"></i>
                </a>
                <a href="#" class="text-inverse text-opacity-25 text-decoration-none" disabled>
                    <i class="fa fa-fw fa-trash"></i>
                </a>
            </div>
            <div class="list-group list-group-flush">
                <div class="list-group-item d-flex px-3">
                    <div class="me-3 pt-1">
                        <img src="assets/img/agents/Ivan.jpg" alt="Agent Image" class="img-fluid rounded-circle" style="max-width: 80px; max-height: 80px;">
                    </div>
                    <div class="flex-fill">
                        <div class="fw-400">Boris Bazarov</div>
                        <div class="small text-inverse text-opacity-50 mb-2">' . htmlspecialchars($row['date']) . '</div>
                        <div class="mb-1">
                            <span class="badge border border-success text-success">
                                <i class="fas fa-check-circle"></i> Verified
                            </span>
                        </div>
                        <hr class="my-3">
                        <div class="fw-400 me-2">
                            ' . htmlspecialchars($row['content']) . '
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <div class="progress progress-xs w-100px me-2 ms-auto" style="height: 6px;">
                                <div class="progress-bar progress-bar-striped bg-success" style="width: 100%;"></div>
                            </div>
                            <div class="fs-12px">100%</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-arrow">
                <div class="card-arrow-top-left"></div>
                <div class="card-arrow-top-right"></div>
                <div class="card-arrow-bottom-left"></div>
                <div class="card-arrow-bottom-right"></div>
            </div>
        </div>
    </div>';
}

$stmt_reports->close();


?>