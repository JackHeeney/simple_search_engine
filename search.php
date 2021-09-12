<?php

// CHECK TO SEE IF THE KEYWORDS WERE PROVIDED
if (isset($_GET['k']) && $_GET['k'] != '') {

    // save the keywords from the url
    $k = trim($_GET['k']);

    // create a base query and words string
    $query_string = "SELECT * FROM search_engine WHERE ";
    $display_words = "";

    // seperate each of the keywords
    $keywords = explode(' ', $k);
    foreach ($keywords as $word) {
        $query_string .= " keywords LIKE '%" . $word . "%' OR ";
        $display_words .= $word . " ";
    }
    $query_string = substr($query_string, 0, strlen($query_string) - 3);

    // connect to the database
    $conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

    $query = mysqli_query($conn, $query_string);
    $result_count = mysqli_num_rows($query);

    // check to see if any results were returned
    if ($result_count > 0) {

        // display search result count to user
        echo '<br /><div class="right"><b><u>' . $result_count . '</u></b> results found</div>';
        echo 'Your search for <i>' . $display_words . '</i> <hr /><br />';

        echo '<table class="search">';

        // display all the search results to the user
        while ($row = mysqli_fetch_assoc($query)) {

            echo '<tr>
									<td><h3><a href="' . $row['url'] . '">' . $row['title'] . '</a></h3></td>
								</tr>
								<tr>
									<td>' . $row['blurb'] . '</td>
								</tr>
								<tr>
									<td><i>' . $row['url'] . '</i></td>
								</tr>';
        }

        echo '</table>';
    } else
        echo 'No results found. Please search something else.';
} else
    echo '';
