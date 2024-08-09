// JavaScript Document


$( document ).ready(function() {




    $('.listItem div').each(function () {
        var delay = ($(this).index()/4) + 's';
        $(this).css({
            webkitAnimationDelay: delay,
            mozAnimationDelay: delay,
            animationDelay: delay
        });
    });
    scaleVideoContainer();

    initBannerVideoSize('.video-container .poster img');
    initBannerVideoSize('.video-container .filter');
    initBannerVideoSize('.video-container video');

    $(window).on('resize', function() {
        scaleVideoContainer();
        scaleBannerVideoSize('.video-container .poster img');
        scaleBannerVideoSize('.video-container .filter');
        scaleBannerVideoSize('.video-container video');
    });

    var top = Math.round($(window).height()/100 * 35) - 80;

    $('.share-buttons-group').affix({
        offset: {
            top: top,
            bottom: 200
        }
    });

});



/** Reusable Functions **/
/********************************************************************/

function scaleVideoContainer() {

    var height = $(window).height();
    var unitHeight = parseInt(height) + 'px';
    $('.homepage-hero-module').css('height',unitHeight);

}

function initBannerVideoSize(element){

    $(element).each(function(){
        $(this).data('height', $(this).height());
        $(this).data('width', $(this).width());
    });

    scaleBannerVideoSize(element);

}

function scaleBannerVideoSize(element){

    var windowWidth = $(window).width(),
        windowHeight = $(window).height(),
        videoWidth,
        videoHeight;


    $(element).each(function(){
        var videoAspectRatio = $(this).data('height')/$(this).data('width');

        $(this).width(windowWidth);

        if(windowWidth < 1000){
            videoHeight = windowHeight;
            videoWidth = videoHeight / videoAspectRatio;
            $(this).css({'margin-top' : 0, 'margin-left' : -(videoWidth - windowWidth) / 2 + 'px'});

            $(this).width(videoWidth).height(videoHeight);
        }

        $('.homepage-hero-module .video-container video').addClass('fadeIn animated');

    });
}
$(document).ready(function(e) {
    $('#mediaCarousel').owlCarousel({
        navigation : false, // Show next and prev buttons
        slideSpeed : 1000,
        paginationSpeed : 400,
        singleItem:true,
        autoPlay: true,
        autoWidth:true,
        pagination:false,
    });


    $(".previousButton").click(function(){
        var owl  = $("#mediaCarousel");
        owl.trigger('owl.prev');
    });

    $(".nextButton").click(function(){
        var owl  = $("#mediaCarousel");
        owl.trigger('owl.next');
    });
});


$(document).ready(function(e) {
    var initPhotoSwipeFromDOM = function(gallerySelector) {

        // parse slide data (url, title, size ...) from DOM elements
        // (children of gallerySelector)
        var parseThumbnailElements = function(el) {
            var thumbElements = el.childNodes,
                numNodes = thumbElements.length,
                items = [],
                figureEl,
                linkEl,
                size,
                item;

            for(var i = 0; i < numNodes; i++) {

                figureEl = thumbElements[i]; // <figure> element

                // include only element nodes
                if(figureEl.nodeType !== 1) {
                    continue;
                }

                linkEl = figureEl.children[0]; // <a> element

                size = linkEl.getAttribute('data-size').split('x');

                // create slide object
                item = {
                    src: linkEl.getAttribute('href'),
                    w: parseInt(size[0], 10),
                    h: parseInt(size[1], 10)
                };



                if(figureEl.children.length > 1) {
                    // <figcaption> content
                    item.title = figureEl.children[1].innerHTML;
                }

                if(linkEl.children.length > 0) {
                    // <img> thumbnail element, retrieving thumbnail url
                    item.msrc = linkEl.children[0].getAttribute('src');
                }

                item.el = figureEl; // save link to element for getThumbBoundsFn
                items.push(item);
            }

            return items;
        };

        // find nearest parent element
        var closest = function closest(el, fn) {
            return el && ( fn(el) ? el : closest(el.parentNode, fn) );
        };

        // triggers when user clicks on thumbnail
        var onThumbnailsClick = function(e) {
            e = e || window.event;
            e.preventDefault ? e.preventDefault() : e.returnValue = false;

            var eTarget = e.target || e.srcElement;

            // find root element of slide
            var clickedListItem = closest(eTarget, function(el) {
                return (el.tagName && el.tagName.toUpperCase() === 'FIGURE');
            });

            if(!clickedListItem) {
                return;
            }

            // find index of clicked item by looping through all child nodes
            // alternatively, you may define index via data- attribute
            var clickedGallery = clickedListItem.parentNode,
                childNodes = clickedListItem.parentNode.childNodes,
                numChildNodes = childNodes.length,
                nodeIndex = 0,
                index;

            for (var i = 0; i < numChildNodes; i++) {
                if(childNodes[i].nodeType !== 1) {
                    continue;
                }

                if(childNodes[i] === clickedListItem) {
                    index = nodeIndex;
                    break;
                }
                nodeIndex++;
            }



            if(index >= 0) {
                // open PhotoSwipe if valid index found
                openPhotoSwipe( index, clickedGallery );
            }
            return false;
        };

        // parse picture index and gallery index from URL (#&pid=1&gid=2)
        var photoswipeParseHash = function() {
            var hash = window.location.hash.substring(1),
                params = {};

            if(hash.length < 5) {
                return params;
            }

            var vars = hash.split('&');
            for (var i = 0; i < vars.length; i++) {
                if(!vars[i]) {
                    continue;
                }
                var pair = vars[i].split('=');
                if(pair.length < 2) {
                    continue;
                }
                params[pair[0]] = pair[1];
            }

            if(params.gid) {
                params.gid = parseInt(params.gid, 10);
            }

            return params;
        };

        var openPhotoSwipe = function(index, galleryElement, disableAnimation, fromURL) {
            var pswpElement = document.querySelectorAll('.pswp')[0],
                gallery,
                options,
                items;

            items = parseThumbnailElements(galleryElement);

            // define options (if needed)

            options = {

                // define gallery index (for URL)
                galleryUID: galleryElement.getAttribute('data-pswp-uid'),

                getThumbBoundsFn: function(index) {
                    // See Options -> getThumbBoundsFn section of documentation for more info
                    var thumbnail = items[index].el.getElementsByTagName('img')[0], // find thumbnail
                        pageYScroll = window.pageYOffset || document.documentElement.scrollTop,
                        rect = thumbnail.getBoundingClientRect();

                    return {x:rect.left, y:rect.top + pageYScroll, w:rect.width};
                }

            };

            // PhotoSwipe opened from URL
            if(fromURL) {
                if(options.galleryPIDs) {
                    // parse real index when custom PIDs are used
                    // http://photoswipe.com/documentation/faq.html#custom-pid-in-url
                    for(var j = 0; j < items.length; j++) {
                        if(items[j].pid == index) {
                            options.index = j;
                            break;
                        }
                    }
                } else {
                    // in URL indexes start from 1
                    options.index = parseInt(index, 10) - 1;
                }
            } else {
                options.index = parseInt(index, 10);
            }

            // exit if index not found
            if( isNaN(options.index) ) {
                return;
            }

            if(disableAnimation) {
                options.showAnimationDuration = 0;
            }

            // Pass data to PhotoSwipe and initialize it
            gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options);
            gallery.init();
        };

        // loop through all gallery elements and bind events
        var galleryElements = document.querySelectorAll( gallerySelector );

        for(var i = 0, l = galleryElements.length; i < l; i++) {
            galleryElements[i].setAttribute('data-pswp-uid', i+1);
            galleryElements[i].onclick = onThumbnailsClick;
        }

        // Parse URL and open gallery if it contains #&pid=3&gid=1
        var hashData = photoswipeParseHash();
        if(hashData.pid && hashData.gid) {
            openPhotoSwipe( hashData.pid ,  galleryElements[ hashData.gid - 1 ], true, true );
        }
    };

// execute above function
    initPhotoSwipeFromDOM('.my-gallery2');
});



$(document).ready(function(e) {
    var $pswp = $('.pswp')[0];
    var image = [];

    $('.picture').each( function() {
        var $pic     = $(this).find('div').find('div'),
            getItems = function() {
                var items = [];
                $pic.find('a').each(function() {
                    var $href   = $(this).attr('href'),
                        $size   = $(this).data('size').split('x'),
                        $width  = $size[0],
                        $height = $size[1];

                    var item = {
                        src : $href,
                        w   : $width,
                        h   : $height
                    }

                    items.push(item);
                });
                return items;
            }

        var items = getItems();

        $.each(items, function(index, value) {
            image[index]     = new Image();
            image[index].src = value['src'];
        });

        $pic.on('click', 'figure', function(event) {
            event.preventDefault();

            var $index = $(this).data("value");
            var options = {
                index: $index,
                bgOpacity: 0.7,
                showHideOpacity: true
            }

            var lightBox = new PhotoSwipe($pswp, PhotoSwipeUI_Default, items, options);
            lightBox.init();
        });
    });
});


$(document).ready(function(e) {
    $(".teamDetails").hide();
    $(".teamCard").click(function(){
        var data2 = [
            {
                name:"Mr. Anil Wadhwa",
                desg:"Vice President Manufacturing",
                about:"Mr. Anil Wadhwa , a Post Graduate in Micro-Biology and has been in the indian liquor industry for over 27 Years. A workaholic person, self motivated, handles independently the manufacturing operations with flair for efficiency and an eye perfection in his work. He is one of the few person in the liquor industry who are trained outside India, in production operations.",
                image:'img/team/anil.png'
            },
            {
                name:"Mr. Manish Singh",
                desg:"General Manager – Technical",
                about:"A Specialist (Alcohol Technologist) with Business Management background, responsible for Grain Spirit production. Mr Manish Singh has worked in reputed International liquor companies in the past and is well known in the alcohol industry.",
                image:'img/team/manish.png'},
            {
                name:"GIRISH SRIVASTAVA",
                desg:"HR & ADMIN Head ",
                about:"A Post Graduate with Masters in Business Management. Mr Srivastava is responsible for Administration and Human Resource Management at ADS Spirits since beginning. He is one of the few persons in the industry who is well versed in commercial aspects of the indian liquor industry and has worked in the past with some of the well known liquor companies in Northern India. He was responsible for obtaining innumerable number of approvals / clearances for smooth and timely operation of the business",
                image:'img/team/girish.png'
            },

            {
                name:"Mr. Pawan Sharma",
                desg:"General Manager –Finance & Accounts",
                about:"Mr. Pawan Sharma leads the finance function as a General Manager Finance & Accounts at ADS Spirits Pvt. Ltd. Since 2013, and is a part of its Group Management. <br> Mr. Pawan Sharma is a MBA – Finance with vast knowledge of Accounting standards and strategies including implementation of SAP/ ERP & has more than 26 years rich experience in accounting especially for Distilleries.He leads a key responsibilities and a team in functional areas of Account / Finance /VAT TAX /Central Excise of ADS Spirits Pvt. Ltd and responsible for various reporting to top management ( MIS ) monitoring & handling of all work of finance & Account Budgeting , Costing, Auditing , VAT , C. Excise  case assessment. He implemented the accounting policies from initial stage for the growth of ADS Spirits Pvt. Ltd.<br>Prior to joining ADS Spirits Pvt. Ltd., Mr. Pawan Sharma was had worked with NV Distilleries Pvt. Ltd., Piccadily Agro Industries Ltd., Ashoka Distillers & Chemicals Pvt. Ltd. and Jai Papers Ltd. Where he leads the Finance and Accounts of organisations. Mr. Pawan Sharma has also served as a Central Government Teacher, Arunachal Pradesh in 1985.",
                image:'img/team/pawan.png'
            },

            {
                name:"Nathi Ram Kapil",
                desg:"Vice President, Sales",
                about:"Mr. N.R. Kapil is Vice President – Sales, having three decades experience in the Indian liquor industry and is responsible for spearheading the business at ADS Spirits. A highly motivated person and with a desire to achieve objective in a fair and ethical manner.",
                image:'img/team/nr.jpg'
            },



            {
                name:"Mr. Sanjay Singh",
                desg:"Deputy General Manager - Engineering",
                about:"Mr. Sanjay Singh has over 29 years of successful professional experience in the distillery projects and maintenance. He joins ADS Spirits Pvt. Ltd. In 2012 from Ankur Biochem Pvt. Ltd. And worked in very renowned distilleries of India like India Glycols Limited, Camphor & Allied Products Ltd where he has attain various achievements in the fields of Mechanical, Electrical, Instrumentation, Civil, Utility, Projects. Prior to that, Mr. Sanjay Singh has done his Bachelor of Technology in Mechanical Engineering from Birla Institute of Technology, Ranchi. He also been awarded ISO integrated management system certifications, and possess excellent communication & organizational ability. Team leader with the ability to mentor.",
                image:'img/team/sanjay.jpg'
            },


            {
                name:"Mr. Tilak Raj Malik",
                desg:"Zonal Head (Sales) at ADS Spirits Private Limited",
                about:"Over 30 Years of experience in Liquor Sales with some of the renowned companies like Shaw Wallace, Remy Martin, Radico khaitan Ltd & Jagatjit Industries Ltd. Prior to this role, Mr. Malik served as Sr. General Manager with Jagatjit Industries Ltd (2014-2016) and looked after the sales business of the company in Haryana. Also, Mr. Malik was Sr. General Manager with Radico Khaitan Ltd (1999- 2014) and was responsible for launching various top brands in the market which was a runaway success for the company.",
                image:'img/team/tilak.jpg'
            },
            {
                name:"Mr. Ashutosh Chaturvedi",
                desg:"Dy. General Manager – Sales & Marketing",
                about:"Mr. Ashutosh Chaturvedi is a Dy. General Manager of Marketing and Sales at ADS Spirits Pvt. Ltd. He has joined ADS Spirits in July 2013 picking up the gauntlet for the marketing division of company. Ashutosh has held coveted positions across blue chip global FMCG companies Ashutosh worked in his career with Shaw Wallace, Champagne Indage Ltd., Simbhaoli Sugars Ltd., Impeial Distilleres and Vintners Pvt. Ltd, TI of India Ltd., Icon Oil and Specialities Ltd, etc and having rich and vast 20 years of Experience in Marketing and Sales area, during his highly successful tenure in the fields of Sales, Ashutosh developed leading edge marketing capability while handling diverse leadership roles across marketing and sales and across different domains –Distilleries , Beverages, Direct Selling and E-Tailing. He held the State of Haryana and was a key member of the ADS Spirits Pvt. Ltd.Ashutosh brings with him an in depth understanding of marketing best practices and processes and is committed to introducing global best practice in ADS marketing. Rejuvenation of existing Category 1 brands, the strategy for the high end premium brands and innovation are the priority areas for Ashutosh and his team. Driven by process and passion, Ashutosh believes that processes help ensure that there is no trade off between speed to market and execution excellence. As a leader, Ashutosh places considerable emphasis on development of people and the team. Ashotosh holds an Master of Business Administration degree from the IIMA-CME, New Delhi and a Post Graduated Diploma in Sales and Marketing from Bharatiya Vidya Mandir, Mumbai. He is also played Cricket at a District Level, Lucknow and likes Badminton. Ashutosh is a work believing and believes in effort done for making work done, Work gets accomplished by effort, industry, not merely by wishing, the animals don't enter a sleeping lion's mouth.",
                image:'img/team/ashutosh.jpg'
            },

            {name:"Mr. G. S. Nagappa",
                desg:"Advisor - National Sales and Marketing",
                about:"A veteran of Indian liquor industry and former Chief Operating Officers of United Spirits Ltd (A Diageo Company), Mr Nagappa brings in wealth of knowledge and experience in sales and marketing to ADS Spirits, as the company is geared to reach consumers in eastern, central and southern India. Mr. Nagappa is guiding the sales and marketing team to address the challenges faced everyday at the market place (Consumer, Retailer, Distributor/Wholesaler).",
                image:'img/team/gsn.jpg',
            },
            {

                name:"Mr. N. Janardana Menon",
                desg:"Advisor - Technical",
                about: "Mr. N J Menon, former head of United Spirits Ltd’s Technical Centre and has more than 50 Years of Experience in Alcohol Beverage Industry in India, which includes Product (Blend) Development, Quality Control, Manufacturing &amp; Maturation of Malt and Grape Spirits. Mr. Menon is responsible for development of some of the well known brands of United Spirits Ltd. <br> Mr Menon is associated with ADS Spirits in the develoment of world class Blends since beginning and visits the production facility at regular intervals to monitor the blend quality and other technical parameters of production. He is considered an expert in Indian whisky blend development.<br> Mr. Menon was a member of Bureau of Indian Standards, Committee on Alcoholic &amp; Beverages, AIDA Technical Committee and other institutions.",
                image:'img/team/menon.jpg',
    },
            {

                name:"Mr. P. V. Achar",
                desg:"Advisor - Supply Chain",
                about: "A Post Graduate in Business Administration with specialisation in Materials Management, having 25 years of experience in the liquor Industry, of which over a decade as Head of Supply Chain (North India) with United Spirits Ltd. Mr PV Achar is well known and most respected person in the liquor industry.<br> Mr PV Achar has inculcated best practices in Supply Chain Management to ADS Spirits from inception and is being continuously improved upon for better efficiency.",
                image:'img/team/pva.jpg',
            },
            {

                name:" Mr. Ashok Kumar Maan ",
                desg:"Promoter Director",
                about: "Mr. Ashok Kumar Maan is a dynamic leader and holds leadership roles in finance, manufacturing and operations of the company. As a founder member, Mr. Ashok Maan has played a key role in setting up the 60 KLPD distillery of the company. He is a family man and the strongest source of motivation to the hardworking team at ADS Spirits.Before this venture, he has been dealing in wholesale and retail trade of liquor for more than 22 years in the state of Haryana",
                image:'img/team/maan.jpg',
            },
            {

                name:"Mr. Sikandar Maan",
                desg:"Promoter Director",
                about: "Mr. Sikandar Maan plays a vital role in the management of the company’s facilities and administration. A sportsman, athlete and true son of the land, Mr. Sikandar Maan loves to travel has used his rich experiences in shaping the ethos and work culture at ADS Spirits. He has been instrumental in ensuring that the growth of ADS is reflected in all areas and facilities from which it operates. Before this venture, he has been dealing in wholesale and retail trade of liquor for the over 18 years in the state of Haryana.",
                image:'img/team/sikandar.jpg',
            },
             {

                name:"Brijesh K Patel",
                desg:"Sr. Vice President (Sales & Marketing)",
                about: "Brijesh K Patel, Sr. Vice President (Sales & Marketing) is responsible for  conceptualizing and executing Sales and Marketing Strategies across Markets. An MBA from premier Management Institute, Brijesh has more than a decade experience in Sales, Key Accounts and Marketing in Various Markets.  With Penchant for Numbers, he believes in power of Simplicity and Team Work.",
                image:'img/team/patel.png',
            },

        ];
        var id= $(this).data("value") -1;
        $(".teamName").html(data2[id].name);
        $(".teamDesg").html(data2[id].desg);
        $(".teamAbout").html(data2[id].about);
        $(".teamImage").attr("src",data2[id].image);
        $(".teamDetails").slideDown(700);
        $('html, body').animate({
            scrollTop: $("#teamContainer").offset().top
        }, 700);
       // $(".teamMembers").slideToggle(700);
    });
    $(".buttonRemove").click(function(){
        $(".teamDetails").slideToggle(700);
     //   $(".teamMembers").slideToggle(700);
    });
});

$(document).ready(function(e) {
    $('#similarCarousel').owlCarousel({
        navigation: false, // Show next and prev buttons
        slideSpeed: 1000,
        autoPlay:true,
        itemsCustom: [
            [0, 2],
            [450, 2],
            [600, 3],
            [700, 3],
            [1000, 4],
            [1200, 4],
            [1400, 4],
            [1600, 6]
        ],
        pagination: true,


    });
});