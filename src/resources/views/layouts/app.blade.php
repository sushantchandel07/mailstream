<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
<head>

    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Mailbox | Africahied</title>
    <style>
        .unread-email .subject b {
            font-weight: bold;
            color: #000;
        }

        .read-email .subject {
            font-weight: normal;
            color: #777;
        }
    </style>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@latest/fonts/remixicon.css">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <script src="https://cdn.ckeditor.com/4.25.0-lts/standard/ckeditor.js"></script>
    <script src="asset{{'quickmail/js/mailbox.js'}}"></script>


    <!-- App favicon -->
    <link rel="shortcut icon" href="/assets/images/favicon.icon">

    <!-- Layout config Js -->
    <script src="{{asset('quickmail/assets/js/layout.js')}}"></script>
    <!-- Bootstrap Css -->
    <!-- Bootstrap Css -->
    <link href="{{asset('quickmail/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />  
    <link href="{{asset('quickmail/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('quickmail/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <!-- <link href="/assets/css/custom.min.css" rel="stylesheet" type="text/css" /> -->

  
</head>
<body>
<div id="layout-wrapper">


    @include('quickmail::partial.header')
    @include('quickmail::partial.sidebar')
    <div class="content">
    <div class="page-content">   
        @yield('content')
        </div>
    </div>
    @include('quickmail::partial.footer')

</div>
    <!-- JAVASCRIPT -->  
     <script>
        function checkBoxAll() {
    // checkbox-wrapper-mail
    Array.from(document.querySelectorAll(".checkbox-wrapper-mail input")).forEach(function (element) {
        element.addEventListener('click', function (el) {
            if (el.target.checked == true) {
                el.target.closest('li').classList.add("active");
            } else {
                el.target.closest('li').classList.remove("active");
            }
        });
    });

    // checkbox
    var checkboxes = document.querySelectorAll('.tab-pane.show .checkbox-wrapper-mail input');
    Array.from(checkboxes).forEach(function (element) {
        element.addEventListener('click', function (event) {
            var checkboxes = document.querySelectorAll('.tab-pane.show .checkbox-wrapper-mail input');
            var checkall = document.getElementById('checkall');
            var checkedCount = document.querySelectorAll('.tab-pane.show .checkbox-wrapper-mail input:checked').length;
            checkall.checked = checkedCount > 0;
            checkall.indeterminate = checkedCount > 0 && checkedCount < checkboxes.length;

            if (event.target.closest('li').classList.contains("active")) {
                (checkedCount > 0) ? document.getElementById("email-topbar-actions").style.display = 'block': document.getElementById("email-topbar-actions").style.display = 'none';
            } else {
                (checkedCount > 0) ? document.getElementById("email-topbar-actions").style.display = 'block': document.getElementById("email-topbar-actions").style.display = 'none';
            }
        });
    });


    function checkAll() {
        var checkboxes = document.querySelectorAll('.tab-pane.show .checkbox-wrapper-mail input');
        var checkedCount = document.querySelectorAll('.tab-pane.show .checkbox-wrapper-mail input:checked').length;
        Array.from(checkboxes).forEach(function (chkbox) {
            chkbox.checked = true;
            chkbox.parentNode.parentNode.parentNode.classList.add("active");
        });
        (checkedCount > 0) ? document.getElementById("email-topbar-actions").style.display = 'none' : document.getElementById("email-topbar-actions").style.display = 'block';

        if (checkedCount > 0) {
            Array.from(checkboxes).forEach(function (chkbox) {
                chkbox.checked = false;
                chkbox.parentNode.parentNode.parentNode.classList.remove("active");
            });
        } else {
            Array.from(checkboxes).forEach(function (chkbox) {
                chkbox.checked = true;
                chkbox.parentNode.parentNode.parentNode.classList.add("active");
            });
        }
        this.onclick = uncheckAll;
        removeItems();
    }

    function uncheckAll() {
        var checkboxes = document.querySelectorAll('.tab-pane.show .checkbox-wrapper-mail input');
        var checkedCount = document.querySelectorAll('.tab-pane.show .checkbox-wrapper-mail input:checked').length;
        Array.from(checkboxes).forEach(function (chkbox) {
            chkbox.checked = false;
            chkbox.parentNode.parentNode.parentNode.classList.remove("active");
        });
        (checkedCount > 0) ? document.getElementById("email-topbar-actions").style.display = 'none' : document.getElementById("email-topbar-actions").style.display = 'block';
        if (checkedCount > 0) {
            Array.from(checkboxes).forEach(function (chkbox) {
                chkbox.checked = false;
                chkbox.parentNode.parentNode.parentNode.classList.remove("active");
            });
        } else {
            Array.from(checkboxes).forEach(function (chkbox) {
                chkbox.checked = true;
                chkbox.parentNode.parentNode.parentNode.classList.add("active");
            });
        }
        this.onclick = checkAll;
    }

    var checkall = document.getElementById("checkall");
    checkall.onclick = checkAll;
}





    document.addEventListener('DOMContentLoaded', function() {
    const emailSubjects = document.querySelectorAll('.email-subject');
    
    emailSubjects.forEach(subject => {
        subject.addEventListener('click', function(e) {
            const emailRecipientId = this.getAttribute('data-email-recipient-id');
            
            fetch(`/mark-as-read/${emailRecipientId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Change styling
                    const parentLi = this.closest('li');
                    parentLi.classList.remove('unread-email');
                    parentLi.classList.add('read-email');
                    
                    // Remove bold formatting
                    const boldElement = this.querySelector('b');
                    if (boldElement) {
                        const textContent = boldElement.textContent;
                        this.innerHTML = textContent;
                    }
                }
            })
            .catch(error => {
                console.error('Error marking email as read:', error);
            });
        });
    });
});
     </script>

    <script src="{{asset('quickmail/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('quickmail/js/simplebar.min.js')}}"></script>
    <script src="{{asset('quickmail/js/waves.min.js')}}"></script>
    <script src="{{asset('quickmail/js/feather.min.js')}}"></script>
    <script src="{{asset('quickmail/js/lord-icon-2.1.0.js')}}"></script>
    <script src="{{asset('quickmail/js/plugins.js')}}"></script>
    <!--ckeditor js-->
    <script src="/assets/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js"></script>
    <!-- mailbox init -->
    <script src="{{asset('quickmail/js/mailbox.init.js')}}"></script>
    <!-- App js -->
    <script src="{{ asset('quickmail/js/app.js') }}"></script>
    <script>
          CKEDITOR.replace('editor');
    </script>
</body>
</html>
