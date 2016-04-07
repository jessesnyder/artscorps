<html>
    <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8">
        <title>Arts Corps - After-School Catalog</title>
    </head>
    <body>
        <div id="class-schedule">
            <h1>Current Arts Corps Courses</h1>
            <div class="error-message"><?php print $view['errors']?></div>
            <?php if(! $view['errors']) { ?>
            <div id="filter-controls">
                <?php foreach($view['filterOptions'] as $option) { 
                    print $option;
                }?>
            </div>
            <h2><?php print $view['currentName'] ?></h2>
            <ul id="current-quarter-classes">
                <?php
                foreach($view['current'] as $grouping => $data) {
                ?>
                <h3><?php print $grouping ?> </h3>
                <table class="<?php print $grouping ?>">
                    <tr><th>Course Name</th><th>Teacher</th><th>Location</th></tr>
                        <?php
                        foreach($data as $class) {
                        ?>
                            <tr>
                                <td><?php print $class['classLink'] ?></td>
                                <td><?php print $class['teacherLink'] ?></td>
                                <td><?php print $class['facilityLink'] ?></td>
                                <td><?php print $class['registerLink'] ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                </table>
                <?php
                }
                ?>
            </ul>
            <h2><?php print $view['nextName'] ?></h2>
            <ul id="next-quarter-classes">
                <?php 
                foreach($view['next'] as $grouping => $data) {
                ?>
                <h3><?php print $grouping ?></h3>
                <table class="<?php print $grouping ?>">
                    <tr><th>Course Name</th><th>Teacher</th><th>Location</th></tr>
                        <?php
                        foreach($data as $class) {
                        ?>
                            <tr>
                                <td><?php print $class['classLink'] ?></td>
                                <td><?php print $class['teacherLink'] ?></td>
                                <td><?php print $class['facilityLink'] ?></td>
                                <td><?php print $class['registerLink'] ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                </table>
                <?php
                }
                ?>            
            </ul>
            </div>
            <p class="annotation">
            These courses are still in the planning stage.  If you don't see what you are looking for,
            please check back again.
            </p>
            <?php } ?>
        </div>
    </body>
</html>