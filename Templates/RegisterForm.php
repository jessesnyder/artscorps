<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    <title>
        Arts Corps - Registration for <?php print $view['name']?>
    </title>
<style type="text/css">
   td { vertical-align: top; }
   label { text-align: right; margin-right: 8px; font-weight: bold; }
</style>
<script language="JavaScript" type="text/javascript">

    function formatPhone(num) {
    var re= /\D/;
    var newNum=num.value;
     if (newNum != "") {
        while (re.test(newNum)) {
         newNum = newNum.replace(re,"");
        }
        if (newNum.length == 7){
           newNum = '(206) ' + newNum.substring(0,3) + '-' + newNum.substring(3,7);
           num.value = newNum;
        }
        if (newNum.length == 10){
           newNum = '(' + newNum.substring(0,3) + ') ' + newNum.substring(3,6) + '-' + newNum.substring(6,10);
           num.value = newNum;
        }
      }
    }

    function formatPhone2(input) {
       if((/^(\d{3})(\d{3})(\d{4})$/).test(input.value)) {
          input.value = '('+RegExp.$1+') ' + RegExp.$2 + '-' + RegExp.$3;
       } else {
          input.value = input.value;
       }
    }

    function verify(theForm)
    {
        var why = "";
        why += checkField(theForm.FirstName.value, "First Name");
        why += checkField(theForm.LastName.value, "Last Name");
        why += checkField(theForm.Phone.value, "Phone Number");
        why += checkField(theForm.Email.value, "Email Address");
        if (why != "") {
            alert(why);
            return false;
        }
        return true;
    }

    function checkField (val, field) {
        var error = "";
        if (val == "") {
            error = "You must enter a value in the " + field + " field\n";
        }
        return error;
    }
</script>
</head>
<body>
    <h1>
        Student Interest Form - <?php print $view['name']?>
    </h1>
    <div class="error-message"><?php print $view['errors']?></div>
    <?php if(! $view['errors']) { ?>
    <!-- <?php print $view['dump']?> -->
    <div id="class-overview">
        <p class="class-name-message">
            Thank you for your interest in taking <?php print $view['name']?>!
        </p>
        <p class="class-description">
            <?php print $view['description']?>
        </p>
        <dl class="class-teacher">
            <dt>Teacher</dt>
            <dd><?php print $view['artistLink']?></dd>
        </dl>
        <?php print $view['coteacher']?>
        <dl class="class-location">
            <dt>Location<dt>
            <dd><?php print $view['facilityLink']?></dd>
        </dl>
        <dl class="class-start">
            <dt>Start Date<dt>
            <dd><?php print $view['dateStart']?></dd>
        </dl>
        <dl class="class-end">
            <dt>End Date<dt>
            <dd><?php print $view['dateEnd']?></dd>
        </dl>
        <dl class="class-no-meeting">
            <dt>No Class<dt>
            <dd><?php print $view['noClassDays']?></dd>
        </dl>
        <dl class="class-days">
            <dt>Meeting days<dt>
            <dd><?php print $view['days']?></dd>
        </dl>
        <dl class="class-time">
            <dt>Meeting time<dt>
            <dd><?php print $view['time']?></dd>
        </dl>
        <dl class="class-ages">
            <dt>Ages<dt>
            <dd><?php print $view['ages']?></dd>
        </dl>
        <dl class="class-capacity">
            <dt>Max students<dt>
            <dd><?php print $view['capacity']?></dd>
        </dl>
    </div>
    <!-- TODO: where do I post? -->
    <form name="course application" action="course_process.php" method="post" onsubmit="return verify(this)" id="course application">
        <?php print $view['hidden-class-field']?>
        <legend>Please fill out this form and then click Submit.</legend>
        <table>
            <tr>
                <td align="right">
                    <label for="FirstName">Your First Name</label>
                </td>
                <td>
                    <input maxlength="40" type="text" id="FirstName" size="20" name="FirstName">
                </td>
            </tr>
            <tr>
                <td align="right">
                    <label for="LastName">Your Last Name</label>
                </td>
                <td>
                    <input maxlength="40" type="text" id="LastName" size="20" name="LastName">
                </td>
            </tr>
            <tr>
                <td align="right">
                    <label for="DOB_Month">Date of Birth</label>
                </td>
                <td>
                    <select name="DOB_Month" size="1">
                        <option value="January">Jan.</option>
                        <option value="February">Feb.</option>
                        <option value="March">March</option>
                        <option value="April">April</option>
                        <option value="May">May</option>
                        <option value="June">June</option>
                        <option value="July">July</option>
                        <option value="August">Aug. </option>
                        <option value="September">Sept.</option>
                        <option value="October">Oct. </option>
                        <option value="November">Nov.</option>
                        <option value="December">Dec.</option>
                    </select>
                    <select name="DOB_Day" size="1">
                        <?php foreach($view['day-options'] as $day) { ?>
                        <option value="<?php print $day ?>">
                            <?php print $day ?>
                        </option>
                        <?php } ?>
                    </select>
                    <select name="DOB_Year" size="1">
                        <?php foreach($view['year-options'] as $year) { ?>
                        <option value="<?php print $year ?>">
                            <?php print $year ?>
                        </option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td align="right">
                    <label for="Email">Email</label>
                </td>
                <td>
                    <input maxlength="80" type="text" id="Email" size="20" name="Email">
                </td>
            </tr>
            <tr>
                <td align="right">
                    <label for="Phone">Phone</label>
                </td>
                <td>
                    <input maxlength="40" type="text" id="Phone" size="20" name="Phone">
                </td>
            </tr>
            <tr>
                <td align="right">
                    <label for="Questions">Comments or Questions</label>
                </td>
                <td>
                    <textarea name="Questions" cols="30"></textarea>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="submit" name="submit" value="Submit">
                </td>
            </tr>
        </table>
    </form>
    <?php } ?>
</body>
</html>
