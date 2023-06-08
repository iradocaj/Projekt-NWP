<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo '<h2 style="font-size: 40px;">Form sent!</h2>';
}
?>

<h1>Contact Form</h1>
<div id="contact">
    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12100.099191798772!2d-111.9903994!3d40.6954515!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xd3eaadaf3debce9a!2sKen%20Garff%20West%20Valley%20Chrysler%20Jeep%20Dodge%20Ram%20FIAT!5e0!3m2!1sen!2shr!4v1571586704721!5m2!1sen!2shr" width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
    <hr>
    <form action="" id="contact_form" name="contact_form" method="POST">
        <label for="fname">First Name *</label>
        <input type="text" id="fname" name="firstname" placeholder="Your name.." required><br>

        <label for="lname">Last Name *</label>
        <input type="text" id="lname" name="lastname" placeholder="Your last name.." required><br>
        
        <label for="lname">Your E-mail *</label>
        <input type="email" id="email" name="email" placeholder="Your e-mail.." required><br>

        <label for="country">Country</label>
        <select id="country" name="country">
          <option value="">Please select</option>
          <option value="BE">Belgium</option>
          <option value="HR" selected>Croatia</option>
          <option value="LU">Luxembourg</option>
          <option value="HU">Hungary</option>
        </select><br>

        <label for="subject">Subject</label><br>
        <textarea id="subject" name="subject" placeholder="Write something.." style="width:500px"></textarea>
        <br>
        <input type="submit" value="Submit"><br>
    </form>
</div>