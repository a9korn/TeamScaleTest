<div class="container">
    <div class="row">
        <div class="col-md-6">
            <h2>Please upload CSV file</h2>
            <form action="/upload" method="post" enctype="multipart/form-data">
                <input type="file" name="fileCSV" class="form-control">
                <button class="btn btn-primary">Get Statistic from CSV</button>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 text-center">
        <h3 class="text-uppercase">Statistics</h3>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>CustomerId</th>
                <th>Number of calls within the same continent</th>
                <th>Total Duration of calls within the same continent</th>
                <th>Total number of all calls</th>
                <th>The total duration of all calls</th>
            </tr>
            </thead>
            <tbody>
        <?php
        foreach ($statistics as $id=>$item) {
            echo "<tr>";
            echo "<td>" . $id . "</td>";
            echo "<td>" . $item['calls'] . "</td>";
            echo "<td>" . $item['duration'] . "</td>";
            echo "<td>" . $item['total_calls'] . "</td>";
            echo "<td>" . $item['total_duration'] . "</td>";
            echo "</tr>";
        }
        echo "<tr class='table-dark'><td colspan='3'>Totals:</td><td>".$total_calls."</td><td>".$total_duration."</td></tr>"

        ?>
            </tbody>
        </table>
        </div>
    </div>
</div> <!-- /container -->