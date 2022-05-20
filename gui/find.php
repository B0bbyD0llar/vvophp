<?php declare(strict_types=1);

require_once("init.php");

global $vvo; // Only for testing purposes

include("top.php"); // HTML Head + Menu
?>
    <form method="get" action="find.php" class="form-inline">
        <label class="sr-only" for="q">Name</label>
        <input type="text" class="form-control mb-2 mr-sm-2" size="60" id="q" name="q"
               value="<?php echo @$_GET['q']; ?>"
               placeholder="type some search term">
        <select class="form-control mb-2 mr-sm-2" name="l" id="l">
            <option>select...</option>
            <option value="5" <?php if ($_GET['l'] == 5) echo "selected"; ?> >5</option>
            <option value="10" <?php if ($_GET['l'] == 10) echo "selected"; ?> >10</option>
            <option value="50" <?php if ($_GET['l'] == 50) echo "selected"; ?> >50</option>
            <option value="" <?php if ($_GET['l'] == 0) echo "selected"; ?> >all</option>
        </select>
        <div class="form-check mb-2 mr-sm-2">
            <input class="form-check-input" name="h" type="checkbox"
                   id="h" <?php if (@$_GET['h'] === "on") echo "checked='checked'"; ?> />
            <label class="form-check-label" for="h">
                only stations
            </label>
        </div>
        <button type="submit" class="btn btn-primary mb-2"><i class="fas fa-search"></i> start search</button>
    </form>
    <hr>
<?php

if (@$_GET['q'] == "") {
    echo '<p>Please perform a search.</p>';
} else {
    echo '<h4>Searched for <i>&quot;' . @$_GET['q'] . '&quot;</i>.</h4>';
    echo '<div style="border: 1px dotted grey; padding: 10px;">';
    echo '<h4 style="padding-bottom: 10px; border-bottom: grey 1px dashed;">Response from the server:</h4>';
    if (@$_GET['l'] > 0) {
        $limit = (int)$_GET['l'];
    } else {
        $limit = null;
    }
    if (@$_GET['h'] === "on") {
        $stops = true;
    } else {
        $stops = false;
    }

    $result = $vvo->searchPoint($_GET['q'], $limit, $stops);
    \Tracy\Debugger::Dump($result);
    echo '</div>';
}
include("foot.php"); // HTML Foot
?>