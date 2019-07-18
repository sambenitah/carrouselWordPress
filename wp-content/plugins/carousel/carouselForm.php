<?php

class carouselForm {

    public function __construct(){
    }

    protected function create_form(){
        $formStr =
    <<< EOF
        <form action="" method="post">
          <div class="form-group">
            <label for="user_name">Nom</label>
            <input type="email" class="form-control" id="user_name" aria-describedby="emailHelp" placeholder="Enter email">
          </div>
          
          <div class="form-group">
            <label for="message">Message</label>
            <textarea class="form-control" id="message" rows="3"></textarea>
          </div>
          
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
EOF;
    }
}