<x-app-layout>
    <x-slot name="addOnCss"></x-slot>
    <div class="contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-7">
                    <h2>Contact Us</h2>
                    <form action="javascript:void(0)">
                        <div class="form-group">
                            <label>nAME</label>
                            <div class="row">
                                <div class="col-md-6">
    
                                    <input type="text" placeholder="First Name">
    
                                </div>
                                <div class="col-md-6">
    
                                    <input type="text" placeholder="Last Name">
    
                                </div>
    
                            </div>
                        </div>
                        <div class="form-group">
    
                            <label>EMAIL</label>
                            <input type="email" placeholder="Enter Email Id">
                        </div>
                        <div class="form-group">
    
                            <label>Subject</label>
                            <input type="text" placeholder="Your Subject">
                        </div>
                        <div class="form-group">
                            <label>Message</label>
                            <textarea placeholder="Message" rows="3"></textarea>
    
                        </div>
                        <button type="submit" class="btn">Submit</button>
                    </form>
                </div>
                <div class=" col-lg-5 col-md-5 contimg">
                    <img src="images/contact.png" alt="">
                </div>
            </div>
        </div>
    </div>
    <x-slot name="addOnJs"></x-slot>
</x-app-layout>



