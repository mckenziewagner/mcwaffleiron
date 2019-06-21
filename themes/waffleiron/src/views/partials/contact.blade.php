@php
  function deliver_mail() {
    // if the submit button is clicked, send the email
    if ( isset( $_POST['message_submit'] ) ) {

      // sanitize form values
      $name    = sanitize_text_field( $_POST["message_name"] );
      $email   = sanitize_email( $_POST["message_email"] );
      $message = esc_textarea( $_POST["message_text"] );

      // get the blog administrator's email address
      $to = get_option( 'admin_email' );

      $headers = "From: $name <$email>" . "\r\n";

      // If email has been process for sending, display a success message
      if ( wp_mail( $to, $subject, $message, $headers ) ) {
        echo '<div>';
        echo '<p>Thanks for contacting me, expect a response soon.</p>';
        echo '</div>';
      } else {
        echo 'An unexpected error occurred';
      }
    }
  }
  deliver_mail();
@endphp
<section id="contact">
  <div class="container-sm flex flex-row pb-32 pt-10">
    <div class="contact-form order-1 w-2/3 pl-12 flex flex-row -mt-3">
      {!! $response !!}
      <form class="w-full" action="{{ esc_url($_SERVER['REQUEST_URI']) }}" method="post">
        <p class="font-sans text-sm uppercase tracking-wide py-2">
          <label for="message_name" class="text-grey">Name:<span class="text-red text-xs">*</span><br>
            <input class="font-serif text-lg p-2 w-full normal-case border border-solid border-green" type="text" name="message_name" value="{{ esc_attr($_POST['message_name']) }}">
          </label>
        </p>
        <p class="font-sans text-sm uppercase tracking-wide py-2">
          <label for="message_email" class="text-grey">Email:<span class="text-red text-xs">*</span><br>
            <input class="font-serif text-lg p-2 w-full normal-case border border-solid border-green" type="text" name="message_email" value="{{ esc_attr($_POST['message_email']) }}">
          </label>
        </p>
        <p class="font-sans text-sm uppercase tracking-wide py-2">
          <label for="message_text" class="text-grey">Message:
            <span class="text-red"> *</span><br>
            <textarea class="font-serif text-lg p-2 w-full normal-case border border-solid border-green" rows="6" name="message_text">
              {{ esc_attr($_POST['message_text']) }}
            </textarea>
          </label>
        </p>
        <input
          class="cursor-pointer p-3 mt-4 bg-green text-white w-full font-sans text-sm font-bold tracking-wider uppercase text-center"
          type="submit"
          name="message_submit"
          value="Submit"
        />
      </form>   
    </div>

    <div class="contact-info text-green order-0 w-1/3 flex flex-col">
      <h3 class="font-serif font-sm italic mb-12 font-normal lg:text-left text-center">
        Great food is one of life's simple pleasures. Classic Events Catering makes this pleasure even simpler by offering custom-built gourmet menus for any occasion. Classic Events Catering is based at Stone Creek Events Center in Urbana.
      </h3>
      <h3 class="uppercase font-sans font-base mb-12 font-normal lg:text-left text-center">
        <a class="text-green hover:text-orange-darker" href="tel:+12173677118">217.367.7118</a>
      </h3>
      <h3 class="uppercase font-sans font-base mb-12 font-normal lg:text-left text-center">
        <a class="text-green hover:text-orange-darker" href="mailto:+1info@classicevents.com">info@classicevents.com</a>
      </h3>
    </div>

  </div>
</section>
<script src="https://www.google.com/recaptcha/api.js?render=6LeQ8pcUAAAAAPCSkQ9cza9dyYwJpb2DPF1iUiIG"></script>
<script>
grecaptcha.ready(function() {
  grecaptcha.execute('6LeQ8pcUAAAAAPCSkQ9cza9dyYwJpb2DPF1iUiIG', {action: 'homepage'}).then(function(token) {
    console.log(`my token: ${token}`)
  });
});
</script>
