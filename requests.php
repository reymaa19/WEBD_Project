<?php
	include('config.php');
	include('connect.php');
	include('functions/functions.php');

    $query = "SELECT * FROM requests ORDER BY start_date DESC";

    if(isset($_POST['sort'])) {
        $query = "SELECT * FROM requests ORDER BY " . $_POST['sort'];
    }

    $current_sort = str_replace('_', ' ', substr($query, 32));

    $result_found = false;

    if(isset($_POST['search'])) {
        $query = "SELECT * 
            FROM requests 
            WHERE INSTR(LOWER(title), '" . strtolower($_POST['search']) . "')  
            OR INSTR(LOWER(description), '" . strtolower($_POST['search']) . "')";
    }
    
    $statement = $db->prepare($query);
    $statement->execute(); 

    $result = $statement->fetchAll();

    if(empty($result)) {
        set_message("No results found.");
    }

    $query = "SELECT * FROM images";
    $statement = $db->prepare($query);
    $statement->execute(); 

    $images = $statement->fetchAll();

    function truncateContent($description) {
        if(strlen($description) <= 200) {
            echo $description;
            return false;
        }
        echo substr($description, 0, 192) . ' ...';
        return true;
    }

	secure();

    include('header.php');
?>
    <div id="wrapper">
		<main>
            <div id="board">
                <h2><a href="Requests.php">Requests Board</a></h2>

                <!-- Search -->
                <form method="post">
                    <label for="searchbar">Search</label>
                    <input type="text" name="search" id="searchbar">
                    <input type="submit" value="Search">
                </form>

                <!-- Sort -->
                <form id="sortform" method="post">
                    <select id="sort" name="sort" onchange="this.form.submit()">
                        <option hidden disabled selected> Sort </option>
                        <option value="title ASC">Title Ascending</option>
                        <option value="title DESC">Title Descending</option>
                        <option value="start_date ASC">Earliest Start Date</option>
                        <option value="start_date DESC">Latest Start Date</option>
                    </select>
                </form>

                <small>Currently sorted by: <?= $current_sort ?></small>

                <!-- Requests -->
                <?php foreach ($result as $row): ?>
                    <div class="request">
                        <h3><a href="read_request.php?id=<?= $row['request_id'] ?>"><?= $row['title'] ?></a></h3>
                        <?php foreach ($images as $image): ?>
                        <?php if ($image['request_id'] == $row['request_id']): ?>
	    					<img src="<?= $image['thumbnail_path'] ?>" alt="<?= $image['thumbnail_path'] ?>">
	    				<?php endif ?>
                        <?php endforeach ?>
                        <?php if (truncateContent($row['description'])): ?>
	    					<a href="show.php?id=<?= $row['request_id'] ?>">Read Full Request</a>
	    				<?php endif ?>
                        <br>
                        <small>Requested start date: <?= $row['start_date'] ?></small>
                    </div>
                <?php endforeach ?>
            </div>
		</main>
	</div>
<?php include('footer.php'); ?>