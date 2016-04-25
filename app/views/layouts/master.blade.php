
<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
   
   
    <!-- custom CSS -->
    <link href="{{ secure_url('css/styles.css') }}" rel="stylesheet">
    
    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

</head>
    <body>
        <!-- Main Container -->
        <div class="container-fluid">
            <!-- Navigation Bar -->
            <nav class="navbar navbar-inverse">
                <div class="container-fluid">
                    <!-- navbar header -->
                    <div class="navbar-header">
                        <!-- toggle button -->
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <!-- Brand Image & Text -->
                        <a class="navbar-brand" href="#">Headbook</a>
                        <p class="navbar-text">Signed in as Janis Ozolins</p>
                    </div>
                    <!-- navbar collapsable part -->
                    <div id="navbar" class="navbar-collapse collapse">
                    <!-- right menu of the nav bar -->
                    <ul class="nav navbar-nav navbar-right">
                      <li class="inactive"><a href="{{ secure_url('/') }}">Posts</a></li>
                      <li><a href="{{ secure_url('/friends') }}">Friends</a></li>
                      <li><a href="../login/">Login</a></li>
                    </ul>
                  </div>
                </div>
            </nav>
            <!-- Main Content -->
            <div id="mainContent" class="row">
                <!-- Left Column -->
                <div align="middle" id="left" class="col-md-3">
                    <div class="row">
                        <div style="background-color: #ffffff; border: 1px solid #ccc; padding:20px;" class="col-md-12">
                            <h1>Janis Ozolins</h1>
                            <img class="profile-pic-sidebar" src="{{ secure_url('img/me.jpg') }}"></img>
                            <div class="col-md-12 profile-box">Live in Gold Coast</div>
                            <div class="col-md-12 profile-box">22 years old</div>
                            <div class="col-md-12 profile-box">Studies at Griffith University</div>
                        </div>
                    </div>
                </div>
                <!-- Middle Column -->
                <div id="right" class="col-md-7">
                    <div class="row">
                        @section('content')
                    @show
                    </div>
                </div>
                <!-- Right Column -->
                <div align="middle" id="left" class="col-md-2">
                    <div class="row">
                        <div style="background-color: #ffffff; border: 1px solid #ccc; padding:20px;" class="col-md-12">
                            <div class="col-md-12 profile-box">More Features Will Be Implemented Here</div>
                            <img class="profile-pic-sidebar" src="{{ secure_url('img/me.jpg') }}"></img>
                            <div class="col-md-12 profile-box">More Features Will Be Implemented Here</div>
                            <img class="profile-pic-sidebar" src="{{ secure_url('img/me.jpg') }}"></img>
                            <div class="col-md-12 profile-box">More Features Will Be Implemented Here</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>