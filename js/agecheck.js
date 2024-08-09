




$(document).ready(function(){

    function setCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays*24*60*60*1000));
        var expires = "expires="+d.toUTCString();
        document.cookie = cname + "=" + cvalue + "; " + expires;
    }

    function getCookie(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for(var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }


   var countries =  [
       {"name":"India","age":21},
       {"name":"Albania","age":21},
       {"name":"Angola","age":21},
       {"name":"Armenia","age":21},
       {"name":"Austria","age":16},
       {"name":"Algeria","age":18},
       {"name":"Argentina","age":18},
       {"name":"Australia","age":18},
       {"name":"Azerbaijan","age":18},
       {"name":"Belgium","age":16},
       {"name":"Bosnia and Herzegovina","age":16},

       {"name":"Bahamas","age":18},
       {"name":"Belarus","age":18},
       {"name":"Belize","age":18},
       {"name":"Bermuda","age":18},
       {"name":"Bolivia","age":18},
       {"name":"Botswana","age":18},
       {"name":"Brazil","age":18},
       {"name":"Burundi","age":18},
       {"name":"Cameroon","age":18},
       {"name":"Canada","age":18},
       {"name":"Cape Verde","age":18},
       {"name":"Central African Republic","age":18},
       {"name":"Chile","age":18},
       {"name":"China","age":18},
       {"name":"Columbia","age":18},
       {"name":"Costa Rica","age":18},
       {"name":"Croatia","age":18},
       {"name":"Czech Republic","age":18},
       {"name":"Cambodia","age":21},
       {"name":"Comoros","age":21},
       {"name":"Cuba","age":21},

       {"name":"Denmark","age":18},
       {"name":"Dominican Republic","age":18},
       {"name":"Equatorial Guinea","age":21},
       {"name":"El Savador","age":18},
       {"name":"Eritrea","age":18},
       {"name":"Estonia","age":18},
       {"name":"Ethiopia","age":18},
       {"name":"Ecuador","age":18},
       {"name":"Egypt","age":18},

       {"name":"Fiji","age":18},
       {"name":"Finland","age":18},
       {"name":"France","age":18},
       {"name":"Ghana","age":21},
       {"name":"Guinea-Bissau","age":21},
       {"name":"Jamaica","age":21},
       {"name":"Macedonia","age":21},
       {"name":"Montenegro","age":21},
       {"name":"Morocco","age":21},
       {"name":"Norway","age":21},
       {"name":"Romania","age":21},
       {"name":"Swaziland","age":21},
       {"name":"Togo","age":21},



       {"name":"Germany","age":16},
       {"name":"Georgia","age":16},
       {"name":"Haiti","age":16},
       {"name":"Italy","age":16},
       {"name":"Liechtenstein","age":16},
       {"name":"Luxembourg","age":16},
       {"name":"Macau","age":16},
       {"name":"Malasia","age":16},
       {"name":"Netherlands","age":16},
       {"name":"Sudan","age":16},
       {"name":"Switzerland","age":16},
       {"name":"Tokelau","age":16},
       {"name":"Cyprus","age":17},
       {"name":"Malta","age":17},




       {"name":"Gabon","age":18},
       {"name":"Gambia","age":18},
       {"name":"Gibraltar","age":18},
       {"name":"Greece","age":18},
       {"name":"Guatemala","age":18},
       {"name":"Guyana","age":18},
       {"name":"Honduras","age":18},
       {"name":"Hong Kong","age":18},
       {"name":"Hungary","age":18},

       {"name":"Iraq","age":18},
       {"name":"Ireland","age":18},
       {"name":"Israel","age":18},
       {"name":"Indonesia","age":21},

       {"name":"Jordan","age":18},
       {"name":"Japan","age":20},
       {"name":"Kazakhstan","age":21},
       {"name":"Kenya","age":18},
       {"name":"Kyrgystan","age":18},
       {"name":"Lebano","age":18},
       {"name":"Lesoto","age":18},
       {"name":"Lithuania","age":18},
       {"name":"Malaw","age":18},
       {"name":"Maldives","age":18},
       {"name":"Mauritius","age":18},
       {"name":"Mexico","age":18},
       {"name":"Moldovia","age":18},
       {"name":"Mongolia","age":18},
       {"name":"Mozambique","age":18},
       {"name":"Namibia","age":18},
       {"name":"Nicaragua","age":19},
       {"name":"Nepal","age":18},
       {"name":"New Zealand","age":18},
       {"name":"Niger","age":18},
       {"name":"Nigeria","age":18},
       {"name":"North Korea","age":18},
       {"name":"Panama","age":18},
       {"name":"Papua New Guinea","age":18},
       {"name":"Peru","age":18},
       {"name":"Philippines","age":18},
       {"name":"Puerto Rico","age":18},
       {"name":"Poland","age":18},
       {"name":"Portugal","age":18},
       {"name":"Republic of China","age":18},
       {"name":"Republic of Congo","age":18},
       {"name":"Russia","age":18},
       {"name":"Rwanda","age":18},
       {"name":"Samoa","age":18},
       {"name":"Serbia","age":18},
       {"name":"Seychelles","age":18},
       {"name":"Singapore","age":18},
       {"name":"Slovakia","age":18},
       {"name":"Slovena","age":18},
       {"name":"South Africa","age":18},
       {"name":"South Korea","age":19},
       {"name":"Spain","age":18},
       {"name":"Sweden","age":18},
       {"name":"Syria","age":18},
       {"name":"Tanzania","age":18},
       {"name":"Thailand","age":18},
       {"name":"Tonga","age":18},
       {"name":"Trinidad and Tobago","age":18},
       {"name":"Tunisia","age":18},
       {"name":"Turkey","age":18},
       {"name":"Turkmenistan","age":18},
       {"name":"Iceland","age":20},
       {"name":"Oman","age":21},
       {"name":"Paraguay","age":20},
       {"name":"Pakistan","age":21},
       {"name":"Palau","age":21},
       {"name":"Sri Lanka","age":21},
       {"name":"United States ","age":21},
       {"name":"Uganda","age":18},
       {"name":"Ukraine","age":18},
       {"name":"United Kingdom","age":18},
       {"name":"United States Virgin Islands","age":18},
       {"name":"Uruguay","age":21},
       {"name":"Vietnam","age":21},
       {"name":"Vanuatu","age":18},
       {"name":"Venezuela","age":18},
       {"name":"Zambia","age":18},
       {"name":"Zimbabwe","age":18},
];
    $.each(countries,function(key,value) {
        $("#selectCountry").append($("<option></option>").text(value.name).val(value.age));
    });
    $("#buttonAge").click(function(){
        var dateAge  =  $("#date").val() + '/' +  $("#month").val() + '/' + $("#year").val();

        if (isDate(dateAge) && $("#selectCountry").val() > 0) {
            var age = calculateAge(parseDate(dateAge), new Date());


            if(age>$("#selectCountry").val())
            {

                setCookie("agefiltered", "1", 365);
                window.location.href = "index.html";
            }
            else
            {
                $("#dateMsg").text("You are not Authorized");
            }
        }

        else

        {
            $("#dateMsg").text("Please Enter Your Date Of Birth");
        }
//listener on date of birth field
    });

//convert the date string in the format of dd/mm/yyyy into a JS date object
    function parseDate(dateStr) {
        var dateParts = dateStr.split("/");
        return new Date(dateParts[2], (dateParts[1] - 1), dateParts[0]);
    }

//is valid date format
    function calculateAge(dateOfBirth, dateToCalculate) {
        var calculateYear = dateToCalculate.getFullYear();
        var calculateMonth = dateToCalculate.getMonth();
        var calculateDay = dateToCalculate.getDate();

        var birthYear = dateOfBirth.getFullYear();
        var birthMonth = dateOfBirth.getMonth();
        var birthDay = dateOfBirth.getDate();

        var age = calculateYear - birthYear;
        var ageMonth = calculateMonth - birthMonth;
        var ageDay = calculateDay - birthDay;

        if (ageMonth < 0 || (ageMonth == 0 && ageDay < 0)) {
            age = parseInt(age) - 1;
        }
        return age;
    }

    function isDate(txtDate) {
        var currVal = txtDate;
        if (currVal == '')
            return true;

        //Declare Regex
        var rxDatePattern = /^(\d{1,2})(\/|-)(\d{1,2})(\/|-)(\d{4})$/;
        var dtArray = currVal.match(rxDatePattern); // is format OK?

        if (dtArray == null)
            return false;

        //Checks for dd/mm/yyyy format.
        var dtDay = dtArray[1];
        var dtMonth = dtArray[3];
        var dtYear = dtArray[5];

        if (dtMonth < 1 || dtMonth > 12)
            return false;
        else if (dtDay < 1 || dtDay > 31)
            return false;
        else if ((dtMonth == 4 || dtMonth == 6 || dtMonth == 9 || dtMonth == 11) && dtDay == 31)
            return false;
        else if (dtMonth == 2) {
            var isleap = (dtYear % 4 == 0 && (dtYear % 100 != 0 || dtYear % 400 == 0));
            if (dtDay > 29 || (dtDay == 29 && !isleap))
                return false;
        }

        return true;
    }

});