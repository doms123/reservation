<?php $this->load->view('client/shared/header'); ?>
<link rel="stylesheet" href="<?php echo base_url('assets/css/contact-message.css');?>">

<div class="content overlay">
        <h1>Contact Us</h1>
        <div class="container">
            <div class="inner white">
                <form class="agile_form contactForm">
                    <div class="two-col clear">
                        <div class="item-col no-bg no-pd customer-form float-rt">
                            <div class="agileits-left mt0">
                                <label>First Name</label>
                                <input type="text" placeholder="First Name" class="firstName" required>
                            </div>
                            <div class="agileits-right mt0">
                                <label>Last Name</label>
                                <input type="text" placeholder="Last Name" class="lastName" required>
                            </div>
                            <div class="clear"></div>
                            <div class="form-label">
                                <label>Email Address</label>
                                <input type="email" placeholder="juandelacruz@gmail.com" class="email" required>
                            </div>
                            <div class="clear"></div>
                            <div class="form-label">
                                <label>Contact Number</label>
                                <input type="text" id="numbersOnly" maxlength="11" placeholder="09XXXXXXXXX" class="contact">
                            </div>
                            <div class="clear"></div>
                            <div class="form-label mb0">
                                <label>Message</label>
                                <textarea name="" id="" cols="30" rows="9" class="message" required></textarea>
                            </div>
                            <div class="clear"></div>
                             <div class="submit">
                                <button class="contactBtn" type="submit">Send message</button>
                            </div>
                        </div>
                        <div class="item-col float-lt">
                            <div class="contact-info">
                            <p class="light-color">We have everything you and your family need for a vacation of a lifetime. Experience the water for excitement and relax in tranquil bliss with your special loved one or with the whole family.<br><br>
We look forward to serve you your most memorable vacation and special life events.</p>
                            <p><span class="bold"><i class="fa fa-map-marker"></i> Address:</span> 806 Purok Pinagpala Brgy. Pinagbarilan, Baliuag, 3006 Bulacan</p>
                            <p><span class="bold"><i class="fa fa-phone"></i> Phone:</span>
                            <a href="tel:09173179720">09173179720</a><br><a href="tel:09338121437">09338121437</a></p>
                            <p><span class="bold"><i class="fa fa-envelope"></i> Email:</span>
                            <a href="mailto:haciendagalea@gmail.com">haciendagalea@gmail.com</a></p>
                            <p><span class="bold"><i class="fa fa-clock-o"></i> Opening Hours:</span>
                            Monday to Sunday, 9:00 AM to 11:00 PM</p>
                           </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
   
    </div>
         <div class="map pc">
            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d30837.926334892905!2d120.85585888774413!3d14.951527824858784!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33965560050f3d6b%3A0xe4c14b4b9f1856cc!2sHacienda+Galea+Resort+and+Events+Place!5e0!3m2!1sen!2sph!4v1554979779533!5m2!1sen!2sph" width="800" height="600" frameborder="0" style="border:0" allowfullscreen></iframe>
        </div>
        <div class="map sp">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d30838.379203232147!2d120.86238205265123!3d14.948376642714697!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33965560050f3d6b%3A0xe4c14b4b9f1856cc!2sHacienda+Galea+Resort+and+Events+Place!5e0!3m2!1sen!2sph!4v1554978954178!5m2!1sen!2sph" width="400" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>
        </div>
<?php $this->load->view('client/shared/footer'); ?>
<script src="<?php echo base_url('assets/js/contact-message.js'); ?>"></script>

<script>
    $(function() {
        // Restricts input for the given textbox to the given inputFilter.
        function setInputFilter(textbox, inputFilter) {
            ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function(event) {
            textbox.addEventListener(event, function() {
                if (inputFilter(this.value)) {
                this.oldValue = this.value;
                this.oldSelectionStart = this.selectionStart;
                this.oldSelectionEnd = this.selectionEnd;
                } else if (this.hasOwnProperty("oldValue")) {
                this.value = this.oldValue;
                this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                }
            });
            });
        }

        setInputFilter(document.getElementById("numbersOnly"), function(value) {
            return /^\d*\.?\d*$/.test(value);
        });
    });
</script>