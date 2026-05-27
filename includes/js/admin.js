jQuery(document).ready(function($) {
    // Provider selection handling
    $('.sdwc-choice-card').on('click', function() {
        var $card = $(this);
        var provider = $card.data('provider');
        
        // Check the radio button
        $card.find('input[type="radio"]').prop('checked', true);
        
        // Update active class on cards
        $('.sdwc-choice-card').removeClass('active');
        $card.addClass('active');
        
        // Show/hide relevant fields sections
        $('.sdwc-fields-section').removeClass('active');
        $('.sdwc-fields-section[data-provider="' + provider + '"]').addClass('active');
    });

    // Initialize display based on checked radio
    var initialProvider = $('input[name="sdwc_recaptcha_keys[captcha_type]"]:checked').val();
    if (initialProvider) {
        $('.sdwc-choice-card[data-provider="' + initialProvider + '"]').addClass('active');
        $('.sdwc-fields-section[data-provider="' + initialProvider + '"]').addClass('active');
    }
});
