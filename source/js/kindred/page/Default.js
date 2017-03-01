goog.provide('kindred.page.Default');

goog.require('goog.events.Event');
goog.require('goog.events.EventTarget');

goog.require('manic.util.ArrayUtil');


goog.require('manic.page.Page');
goog.require('manic.google.Map2');


goog.require('kindred.component.DesktopInstagramSlider');
goog.require('kindred.component.DesktopHeader');
goog.require('kindred.component.MobileHeader');
goog.require('kindred.component.MailingListPopup');
goog.require('kindred.component.Giftcard');
goog.require('kindred.component.AccountContent');
goog.require('kindred.component.MobileRelatedProductsSlider');


/**
 * The Default Page constructor
 * @inheritDoc
 * @constructor
 * @extends {manic.page.Page}
 */
kindred.page.Default = function(options) {

  manic.page.Page.call(this, options);
  this.options = $.extend(this.options, kindred.page.Default.DEFAULT, options);


  if ($('body').hasClass('chinese-version')) {
    manic.SITE_LANGUAGE = 'cn';
  }
  if ($('body').hasClass('bahasa-version')) {
    manic.SITE_LANGUAGE = 'in';
  }


  
  this.desktop_header_element = $('#desktop-header');
  this.desktop_footer_element = $('#desktop-footer');

  this.mobile_header_element = $('#mobile-header');
  this.mobile_footer_element = $('#mobile-footer');
  
  this.main_content_element = $('#PageContainer .main-content');
  

  /**
   * @type {kindred.component.DesktopInstagramSlider}
   */
  this.desktop_instagram_slider = null;

  /**
   * @type {kindred.component.DesktopHeader}
   */
  this.desktop_header = null;

  /**
   * @type {kindred.component.MobileHeader}
   */
  this.mobile_header = null;


  this.is_account_page = false;

  /**
   * @type {kindred.component.AccountContent}
   */
  this.account_content = null;
  
  // needed before init, because of reasons :D
  
  if ($('#page-account-page-indicator').length != 0){
    this.is_account_page = true;

    // only instanciate the account content on the account page...
    if ($('#page-account-main-container').length != 0) {
      this.account_content = new kindred.component.AccountContent({}, $('#page-account-main-container'));
    }
  }
  
  this.home_banner_mobile_full_height = $('#home-page-banner-mobile .banner-image-bg .manic-image-container, #home-page-banner-mobile .home-page-banner-item-mobile');

  /**
   * @type {kindred.component.MailingListPopup}
   */
  this.mailing_list_popup = null;


  /**
   * @type {manic.google.Map2}
   */
  this.contact_map = null;

  /**
   * @type {manic.google.Map2}
   */
  this.contact_map_mobile = null;
  
  /**
   * @type {kindred.component.Giftcard}
   */
  this.giftcard = null;


  /**
   * @type {kindred.component.MobileRelatedProductsSlider}
   */
  this.mobile_related_product_slider = null;


};
goog.inherits(kindred.page.Default, manic.page.Page);


/**
 * like jQuery options
 * @const {object}
 */
kindred.page.Default.DEFAULT = {
};

/**
 * Default Event Constant
 * @const
 * @type {string}
 */
kindred.page.Default.EVENT_01 = '';

/**
 * Default Event Constant
 * @const
 * @type {string}
 */
kindred.page.Default.EVENT_02 = '';



//    ___ _   _ ___ _____
//   |_ _| \ | |_ _|_   _|
//    | ||  \| || |  | |
//    | || |\  || |  | |
//   |___|_| \_|___| |_|
//



/**
 * @override
 */
kindred.page.Default.prototype.init = function() {
  kindred.page.Default.superClass_.init.call(this);



  if ($('#desktop-header').length != 0) {
    this.desktop_header = new kindred.component.DesktopHeader({}, $('#desktop-header'));
  }

  if ($('#mobile-header').length != 0 && $('#mobile-header-expanded').length != 0){
    this.mobile_header = new kindred.component.MobileHeader({}, $('#mobile-header'));
  }
  

  


  this.create_home_page();
  this.create_product_page();
  this.create_contact_page();

  this.create_misc_page();



  // create only when in desktop mode
  
  if ($('#mailing-list-pop-up-container').length != 0 && manic.IS_MOBILE == false) {

    // this will auto open if there is no cookie 
    // cookie expires in 10 hrs
    this.mailing_list_popup = new kindred.component.MailingListPopup({}, $('#mailing-list-pop-up-container'));

  }



  /*
  // for checking first letter 
  setInterval(function(){
    var character = Math.random().toString(36).replace(/[^a-z]+/g, '').substr(0, 1);
    $('span.first-letter').html(character);

  }, 300);
  */
  
  
  console.log('kindred.page.Default: init');
};







//    _   _  ___  __  __ _____   ____   _    ____ _____
//   | | | |/ _ \|  \/  | ____| |  _ \ / \  / ___| ____|
//   | |_| | | | | |\/| |  _|   | |_) / _ \| |  _|  _|
//   |  _  | |_| | |  | | |___  |  __/ ___ \ |_| | |___
//   |_| |_|\___/|_|  |_|_____| |_| /_/   \_\____|_____|
//

kindred.page.Default.prototype.create_home_page = function() {




  if ($('#home-page-banner').length != 0) {

    // update on slick init/resize
    $('#home-page-banner').on('init', function(event, slick){
      this.create_image_container();
    }.bind(this));
    $('#home-page-banner').on('breakpoint init reInit setPosition', function(event, slick, breakpoint){
      this.update_page_layout();
    }.bind(this));

    $('#home-page-banner').slick({
      'speed': 350,
      'dots': false,
      // 'arrows': false,
      'arrows': true,
      'infinite': false,
      'slidesToShow': 1,
      'slidesToScroll': 1,
      'pauseOnHover': false,
      'autoplay': true,
      'autoplaySpeed': 4000
    });

    
    
  } // #home-page-banner


  if ($('#home-page-banner-mobile').length != 0) {

    // update on slick init/resize
    $('#home-page-banner-mobile').on('init', function(event, slick){
      this.create_image_container();
    }.bind(this));
    $('#home-page-banner-mobile').on('breakpoint init reInit setPosition', function(event, slick, breakpoint){
      this.update_page_layout();
    }.bind(this));

    $('#home-page-banner-mobile').slick({
      'speed': 350,
      'dots': false,
      'arrows': false,
      'infinite': false,
      'slidesToShow': 1,
      'slidesToScroll': 1,
      'pauseOnHover': false,
      'autoplay': true,
      'autoplaySpeed': 4000
    });

    
    
  } // #home-page-banner-mobile





  if ($('#home-page-shop-item-container').length != 0) {

    // update on slick init/resize
    $('#home-page-shop-item-container').on('init', function(event, slick){
      this.create_image_container();
    }.bind(this));
    $('#home-page-shop-item-container').on('breakpoint init reInit setPosition', function(event, slick, breakpoint){
      this.update_page_layout();
    }.bind(this));

    $('#home-page-shop-item-container').slick({
      'speed': 350,
      'dots': false,
      'arrows': true,
      'infinite': false,
      'slidesToShow': 5,
      'slidesToScroll': 5,
      'pauseOnHover': true,
      // 'autoplay': true,
      'autoplay': false,
      'autoplaySpeed': 4000,
      'responsive': [
        {
          'breakpoint': 1180,
          'settings':{
            'slidesToShow': 4,
            'slidesToScroll': 4
          }
        },
        {
          'breakpoint': 1010,
          'settings':{
            'slidesToShow': 3,
            'slidesToScroll': 3
          }
        }
      ]
    });

    


    var home_scene = new ScrollMagic.Scene({
      'triggerHook': 0.5,
      'triggerElement': '#home-page-shop-section',
      reverse: false
    });

    home_scene.on('enter', function(event){
      // $('#home-page-shop-item-container')
      $('#home-page-shop-item-container').slick('slickSetOption', 'autoplay', true, true);


    }.bind(this));

    // home_scene.addIndicators({name: "Home Shop"});
    home_scene.addTo(this.controller);

    
  } // #home-page-shop-item-container




  if ($('#home-instagram-slider').length != 0) {


    this.desktop_instagram_slider = new kindred.component.DesktopInstagramSlider({}, $('#home-instagram-slider'));
    
    goog.events.listen(this.desktop_instagram_slider, kindred.component.DesktopInstagramSlider.ON_INSTAGRAM_FEED_GENERATED, function(event){

      console.log('instagram feed generated');
      this.create_image_container();

    }.bind(this));

  } // #home-instagram-slider






};

//    ____  ____   ___  ____  _   _  ____ _____   ____   _    ____ _____
//   |  _ \|  _ \ / _ \|  _ \| | | |/ ___|_   _| |  _ \ / \  / ___| ____|
//   | |_) | |_) | | | | | | | | | | |     | |   | |_) / _ \| |  _|  _|
//   |  __/|  _ <| |_| | |_| | |_| | |___  | |   |  __/ ___ \ |_| | |___
//   |_|   |_| \_\\___/|____/ \___/ \____| |_|   |_| /_/   \_\____|_____|
//

kindred.page.Default.prototype.create_product_page = function() {

  // RANDOMIZE PRODUCT DETAIL 'related items' section
  

  if ($('#product-page-also-like-section #all-related-product-item-container').length != 0 && $('#product-page-also-like-section #product-item-container').length != 0) {
    

    // product-item-column

    var arr = $('#product-page-also-like-section #all-related-product-item-container').find('.product-item-column');
    var item = null;
    var item_array = [];
    for (var i = 0, l=arr.length; i < l; i++) {
      item = $(arr[i]);
      item_array[i] = item;
    }

    item_array = manic.util.ArrayUtil.shuffle(item_array);

    var fragment = $(document.createDocumentFragment());
    

    // get first 3
    for (var i = 0, l=4; i < l; i++) {
      item = item_array[i];
      fragment.append(item);
    }

    $('#product-page-also-like-section #product-item-container .row').empty();
    $('#product-page-also-like-section #product-item-container .row').append(fragment);
    
    this.create_image_container();

  } // #product-page-also-like-section




  

  // mobile related items

  if ($('#product-page-also-like-section-mobile').length != 0) {

    this.mobile_related_product_slider = new kindred.component.MobileRelatedProductsSlider({}, $('#product-page-also-like-section-mobile'));

    // slick init
    goog.events.listen(this.mobile_related_product_slider, kindred.component.MobileRelatedProductsSlider.SLIDER_INIT, function(event){
      this.create_image_container();
    }.bind(this));

    // slick resize
    goog.events.listen(this.mobile_related_product_slider, kindred.component.MobileRelatedProductsSlider.SLIDER_UPDATE, function(event){
      this.update_page_layout();
    }.bind(this));

  }




  if ($('#product-page-giftcard-design-container').length != 0) {
    this.giftcard = new kindred.component.Giftcard({}, $('#product-page-giftcard-design-container'));
  }



};

//     ____ ___  _   _ _____  _    ____ _____   ____   _    ____ _____
//    / ___/ _ \| \ | |_   _|/ \  / ___|_   _| |  _ \ / \  / ___| ____|
//   | |  | | | |  \| | | | / _ \| |     | |   | |_) / _ \| |  _|  _|
//   | |__| |_| | |\  | | |/ ___ \ |___  | |   |  __/ ___ \ |_| | |___
//    \____\___/|_| \_| |_/_/   \_\____| |_|   |_| /_/   \_\____|_____|
//

kindred.page.Default.prototype.create_contact_page = function() {



  // upload via imgur (on bank detail page)
  
  if ($('#imgur-upload-container').length != 0) {
    
    new Imgur({
      clientid: '08e0d0ee169efcf',
      callback: function(res){
        if (res.success === true) {

          var image_src = res.data.link;
          image_src = image_src.replace(/^http:/, 'https:');

          console.log('image uploaded');
          console.log(image_src);

          $('#imgur-upload-container #ContactFormImage').val('' + image_src);
          $('#imgur-upload-container').addClass('loaded-version');
          $('#imgur-upload-container').append('<div class="manic-image-container has-show-all"><img src="' + image_src + '"></div>');
          this.create_image_container();
        }
      }.bind(this)
    });

  }



  // create contact us detail map

  if ($('#contact-page-detail-map').length != 0) {
    this.contact_map = new manic.google.Map2({}, $('#contact-page-detail-map'));
  }

  
  if ($('#contact-page-detail-map-mobile').length != 0) {
    this.contact_map_mobile = new manic.google.Map2({}, $('#contact-page-detail-map-mobile'));
  }


  


};




//     ___ _____ _   _ _____ ____    __  __ ___ ____   ____   ____   _    ____ _____ ____
//    / _ \_   _| | | | ____|  _ \  |  \/  |_ _/ ___| / ___| |  _ \ / \  / ___| ____/ ___|
//   | | | || | | |_| |  _| | |_) | | |\/| || |\___ \| |     | |_) / _ \| |  _|  _| \___ \
//   | |_| || | |  _  | |___|  _ <  | |  | || | ___) | |___  |  __/ ___ \ |_| | |___ ___) |
//    \___/ |_| |_| |_|_____|_| \_\ |_|  |_|___|____/ \____| |_| /_/   \_\____|_____|____/
//

kindred.page.Default.prototype.create_misc_page = function() {
  // to force the guest login 'link' to be a submit
  if ($('#page-login-guest-login-container').length != 0) {
    $('#page-login-guest-login-btn').click(function(event){
      $('#page-login-guest-login-container form').submit();
    });
  }

  // wrap article images in a row & manic-image-container 
  
  if ($('.blog-page-article.article-version').length != 0) {
    var arr = $('.blog-page-article.article-version .blog-page-article-content img');
    var item = null;

    for (var i = 0, l=arr.length; i < l; i++) {
      item = $(arr[i]);
      item.wrap('<div class="row"><div class="col-md-10 col-md-push-1"><div class="blog-page-article-content-image manic-image-container"></div></div></div>');
    }

    this.create_image_container();  // instantiate them

  } // end if article-version





};



//    ____  ____  _____     ___  _____ _____
//   |  _ \|  _ \|_ _\ \   / / \|_   _| ____|
//   | |_) | |_) || | \ \ / / _ \ | | |  _|
//   |  __/|  _ < | |  \ V / ___ \| | | |___
//   |_|   |_| \_\___|  \_/_/   \_\_| |_____|
//



kindred.page.Default.prototype.private_method_04 = function() {};
kindred.page.Default.prototype.private_method_05 = function() {};
kindred.page.Default.prototype.private_method_06 = function() {};


//    ____  _   _ ____  _     ___ ____
//   |  _ \| | | | __ )| |   |_ _/ ___|
//   | |_) | | | |  _ \| |    | | |
//   |  __/| |_| | |_) | |___ | | |___
//   |_|    \___/|____/|_____|___\____|
//

kindred.page.Default.prototype.public_method_03 = function() {};
kindred.page.Default.prototype.public_method_04 = function() {};
kindred.page.Default.prototype.public_method_05 = function() {};
kindred.page.Default.prototype.public_method_06 = function() {};




//    _        _ __   _____  _   _ _____
//   | |      / \\ \ / / _ \| | | |_   _|
//   | |     / _ \\ V / | | | | | | | |
//   | |___ / ___ \| || |_| | |_| | | |
//   |_____/_/   \_\_| \___/ \___/  |_|
//


/**
 * @override
 * @inheritDoc
 */
kindred.page.Default.prototype.update_page_layout = function(){
  kindred.page.Default.superClass_.update_page_layout.call(this);

  // set min height of main content
  

  // manic.IS_MOBILE_HEADER

  if (manic.IS_MOBILE_HEADER == false) {
    // only if desktop
    
    var target_min_height = this.window_height - this.desktop_header_element.outerHeight() - this.desktop_footer_element.outerHeight();

    // console.log('this.desktop_header_element.height(): ' + this.desktop_header_element.outerHeight());
    // console.log('this.desktop_footer_element.height():' + this.desktop_footer_element.outerHeight());
    

    this.main_content_element.css({
      'min-height': target_min_height + 'px'
    });


  } else {

    // take a look a the height of the header and footer
    
    var target_min_height = this.window_height - this.mobile_header_element.outerHeight() - this.mobile_footer_element.outerHeight();

    this.main_content_element.css({
      'min-height': target_min_height + 'px'
    });




    // home banner full height of mobile phone
    
    if (this.home_banner_mobile_full_height.length != 0 ) {
      target_min_height = this.window_height - this.mobile_header_element.outerHeight();

      this.home_banner_mobile_full_height.css({
        'min-height': target_min_height + 'px'
      });

      this.update_manic_image_containers();
    }

  }

  /*
  if ($('#home-page-banner').length != 0 && $('#home-page-banner').hasClass('slick-initialized') == true) {
    $('#home-page-banner').slick('setPosition');
  }
  if ($('#home-page-shop-item-container').length != 0 && $('#home-page-shop-item-container').hasClass('slick-initialized') == true) {
    $('#home-page-shop-item-container').slick('setPosition');
  }
  */

  // $('.your-element').slick('setPosition');

};


//    _______     _______ _   _ _____ ____
//   | ____\ \   / / ____| \ | |_   _/ ___|
//   |  _|  \ \ / /|  _| |  \| | | | \___ \
//   | |___  \ V / | |___| |\  | | |  ___) |
//   |_____|  \_/  |_____|_| \_| |_| |____/
//

/**
 * @param {object} event
 */
kindred.page.Default.prototype.on_event_handler_01 = function(event) {

  // desktop-header-spacer
};

/**
 * @param {object} event
 */
kindred.page.Default.prototype.on_event_handler_02 = function(event) {
};

/**
 * @param {object} event
 */
kindred.page.Default.prototype.on_event_handler_03 = function(event) {
};

/**
 * @param {object} event
 */
kindred.page.Default.prototype.on_event_handler_04 = function(event) {
};






kindred.page.Default.prototype.sample_method_calls = function() {

  // sample override
  kindred.page.Default.superClass_.method_02.call(this);

  // sample event
  this.dispatchEvent(new goog.events.Event(kindred.page.Default.EVENT_01));
};





//    _   _    _    ____  _   _ _____  _    ____ ____
//   | | | |  / \  / ___|| | | |_   _|/ \  / ___/ ___|
//   | |_| | / _ \ \___ \| |_| | | | / _ \| |  _\___ \
//   |  _  |/ ___ \ ___) |  _  | | |/ ___ \ |_| |___) |
//   |_| |_/_/   \_\____/|_| |_| |_/_/   \_\____|____/
//


/**
 * @override
 * @inheritDoc
 */
kindred.page.Default.prototype.scroll_to_target = function(str_param, str_param_2, str_param_3) {
  kindred.page.Default.superClass_.scroll_to_target.call(this, str_param, str_param_2, str_param_3);


  if (this.account_content != null){

    this.account_content.set_tab(str_param);
  }
}

/**
 * @override
 * @inheritDoc
 */
kindred.page.Default.prototype.on_scroll_to_no_target = function() {
  kindred.page.Default.superClass_.on_scroll_to_no_target.call(this);

  if (this.account_content != null){
    this.account_content.set_tab(null);
  }
}

