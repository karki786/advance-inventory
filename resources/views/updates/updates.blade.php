@extends('layouts.master')

@section('title')
    {!! env('COMPANY_NAME') !!} | Updates and HotFixes
@endsection


@section('heading')
    Stock Awesome Updates
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default cls-panel" >
              <div class="panel-heading">
                <h3 class="panel-title">
                    StockAwesome Hotfix and Updates List
                </h3>
              </div>

              <div class="panel-body">
                  <!-- Begin MailChimp Signup Form -->
                  <link href="//cdn-images.mailchimp.com/embedcode/slim-10_7.css" rel="stylesheet" type="text/css">
                  <style type="text/css">
                      #mc_embed_signup{background:#fff; clear:left; font:14px Helvetica,Arial,sans-serif; }
                      /* Add your own MailChimp form style overrides in your site stylesheet or in this style block.
                         We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
                  </style>
                  <div id="mc_embed_signup">
                      <form action="//codedcell.us12.list-manage.com/subscribe/post?u=d63ab85671fcbe5c80aa36530&amp;id=dac91dd1ba" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
                          <div id="mc_embed_signup_scroll">
                              <!--<label for="mce-EMAIL">StockAwesome Hotfix and Update List</label>-->
                              <input type="email" style="width: 100%;" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="email address" required>
                              <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                              <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_d63ab85671fcbe5c80aa36530_dac91dd1ba" tabindex="-1" value=""></div>
                              <div class="clear"><input type="submit" style="width: 100%;" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button btn btn-flat bg-green"></div>
                          </div>
                      </form>
                  </div>

                  <!--End mc_embed_signup-->
              </div>

            </div>

        </div>
        <div class="col-md-6">
<div class="panel panel-default cls-panel" >
  <div class="panel-heading">
    <h3 class="panel-title">
    Sign Up for Email Stock Awesome Updates
    </h3>
  </div>

  <div class="panel-body">
    <ul>
        <li>We never SPAM you. We email Only Once Per Week</li>
        <li>We Only email you about StockAwesome and nothing else</li>
        <li>We email you about new addons at discounted prices</li>
        <li>We email you about new Features</li>
        <li>We email you when we are free for freelance work</li>
        <li>We email you when we have created new videos about StockAwesome</li>
    </ul>
  </div>

</div>
        </div>
    </div>


    <iframe class="airtable-embed" src="https://airtable.com/embed/shrhhTKqeMUWZRo5d?backgroundColor=orange"
            frameborder="0" onmousewheel="" width="100%" height="533"
            style="background: transparent; border: 1px solid #ccc;"></iframe>


@endsection


@section('jquery')
    <script>
        $(document).ready(function () {

            $("body").addClass('sidebar-collapse');
        });
    </script>
@endsection

