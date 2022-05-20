<?php declare(strict_types=1);

require_once("init.php");

global $vvo; // Only for testing purposes

include("top.php"); // HTML Head + Menu
?>
    <form method="get" action="monitor.php" class="form-inline">
        <label class="sr-only" for="q">Name</label>
        <input type="text" class="form-control mb-2 mr-sm-2" size="60" id="q" name="q"
               value="<?php echo @$_GET['q']; ?>"
               placeholder="station id">
        <button type="submit" class="btn btn-primary mb-2"><i class="fas fa-search"></i> start search</button>
    </form>
    <hr>
<?php
if (@$_GET['q'] == "") {
    echo '<p>Please perform a search.</p>';
} else {
    echo '<h4>Searched for <i>&quot;' . @$_GET['q'] . '&quot;</i>.</h4>';
    echo '<div style="border: 1px dotted grey; padding: 10px;">';
    echo '<h4 style="padding-bottom: 10px; border-bottom: grey 1px dashed;">Response from server:</h4>';
    $data = $vvo->getMonitorData((int)$_GET['q']);
    \Tracy\Debugger::Dump($data);
    echo '</div>';
}

include("foot.php"); // HTML Foot
?>