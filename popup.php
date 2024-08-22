<?php
// popup.php

session_start(); // Ensure session is started

// Check if user is logged in
if (!isset($_SESSION['user_email']) || (isset($_SESSION['is_admin']) && $_SESSION['is_admin'])) {
    header("Location: task7.php"); // Redirect to login if not logged in or is an admin
    exit();
}

// Database connection
$servername = "localhost";
$username = "yaseen";
$password = "Yaseen@123";
$dbname = "own_cart";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user information
$email = $_SESSION['user_email'];
$stmt = $conn->prepare("SELECT full_name FROM users WHERE email=?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($fullName);
$stmt->fetch();
$stmt->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Popup</title>
    <style>
        .popup {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to right, rgba(0, 121, 107, 0.3), rgba(0, 77, 64, 0.3));
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }
        .popup-content {
            background: rgba(0, 0, 0, 0);
            padding: 20px;
            border-radius: 5px;
            text-align: center;
            color: #FFD700;
            position: relative;
        }
        .close-popup {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
            font-size: 24px;
        }
        h5 {
            font-family: Arial Black;
            font-size: 24px;
            margin: 0;
        }
        h6 {
            font-family: Arial Black;
            font-size: 50px;
            margin: 0;
        }
        .dis {
            margin: 0;
        }
        .container {
  text-align: center;
}

.text-3d {
    font-size: 48px; /* Adjust the size as needed */
    color: #ffffff; /* White color */
    text-shadow:
        1px 1px 0 #004d40, /* Green shadow */
        2px 2px 0 #004d40, /* Green shadow */
        3px 3px 0 #004d40; /* Green shadow */
    transform: rotateY(10deg); /* Optional 3D rotation */
    transform-style: preserve-3d;
    display: inline-block;
}

/* Optional: Adjusting header sizes if needed */
h5.text-3d {
    font-size: 36px;

}

h6.text-3d {
  font-size: 48px;

}
    


.flip-clock {
  text-align: center;
  perspective: 400px;
  margin: 20px auto;
  
  *,
  *:before,
  *:after { box-sizing: border-box; }
}

.flip-clock__piece {
  display: inline-block;
  margin: 0 5px;
}

.flip-clock__slot {
  font-size: 2vw;
}

@halfHeight: 0.72em;
@borderRadius: 0.15em;

.card {
  display: block;
  position: relative; 
  padding-bottom: @halfHeight;
  font-size: 3vw;
  line-height: 0.95;
}

.card__top,
.card__bottom,
.card__back::before,
.card__back::after {
  display: block;
  height: @halfHeight;
  color: #ccc;
  background: #222;
  padding: 0.25em 0.25em;
  border-radius: @borderRadius @borderRadius 0 0;
  backface-visiblity: hidden;
  transform-style: preserve-3d;
  width: 1.8em;
  transform: translateZ(0);
}

.card__bottom { 
  color: #FFF;
  position: absolute;
  top: 50%;
  left: 0;
  border-top: solid 1px #000;
  background: #393939; 
  border-radius: 0 0 @borderRadius @borderRadius; 
  pointer-events: none;
  overflow: hidden;
}

.card__bottom::after {
  display: block;
  margin-top: -@halfHeight;
}

.card__back::before,
.card__bottom::after {
  content: attr(data-value);
}

.card__back {
  position: absolute;
  top: 0;
  height: 100%;
  left: 0%;
  pointer-events: none;
}

.card__back::before {
  position: relative;
  z-index: -1;
  overflow: hidden;
}

.flip .card__back::before {
  animation: flipTop 0.3s cubic-bezier(.37,.01,.94,.35);
  animation-fill-mode: both;
  transform-origin: center bottom;
}

.flip .card__back .card__bottom {
  transform-origin: center top;
  animation-fill-mode: both;
  animation: flipBottom 0.6s cubic-bezier(.15,.45,.28,1);// 0.3s; 
}

@keyframes flipTop {
  0% {
    transform: rotateX(0deg);
    z-index: 2;
  }
  0%, 99% {
    opacity: 0.99;
  }
  100% {
    transform: rotateX(-90deg);
    opacity: 0;
  }
}

@keyframes flipBottom {
  0%, 50% {
    z-index: -1;
    transform: rotateX(90deg);
    opacity: 0;
  }
  51% {
    opacity: 0.99;
  }
  100% {
    opacity: 0.99;
    transform: rotateX(0deg);
    z-index: 5;
  }
}


    </style>
</head>
<body>
<?php if (isset($fullName)): ?>
    <div id="welcome-popup" class="popup">
        <div class="popup-content">
            <span class="close-popup">&times;</span>
            <div class="container">
                <h5 class="text-3d">Welcome to Docme Store</h5><br>
                <h6 class="text-3d"><?php echo htmlspecialchars($fullName); ?>!</h6>
            </div>
            <img class="dis" src="off.png" width="600px"><br>
            <div id="countdown" class="flip-clock"></div>
        </div>
    </div>
    <script>
    function CountdownTracker(label, value) {
        var el = document.createElement('span');
        el.className = 'flip-clock__piece';
        el.innerHTML = '<b class="flip-clock__card card">' +
            '<b class="card__top"></b>' +
            '<b class="card__bottom"></b>' +
            '<b class="card__back">' +
                '<b class="card__bottom"></b>' +
            '</b>' +
        '</b>' +
        '<span class="flip-clock__slot">' + label + '</span>';
        this.el = el;

        var top = el.querySelector('.card__top'),
            bottom = el.querySelector('.card__bottom'),
            back = el.querySelector('.card__back'),
            backBottom = el.querySelector('.card__back .card__bottom');

        this.update = function(val) {
            val = ('0' + val).slice(-2);
            if (val !== this.currentValue) {
                if (this.currentValue >= 0) {
                    back.setAttribute('data-value', this.currentValue);
                    bottom.setAttribute('data-value', this.currentValue);
                }
                this.currentValue = val;
                top.innerText = this.currentValue;
                backBottom.setAttribute('data-value', this.currentValue);

                this.el.classList.remove('flip');
                void this.el.offsetWidth;
                this.el.classList.add('flip');
            }
        }

        this.update(value);
    }

    function getTimeRemaining(endtime) {
        var t = Date.parse(endtime) - Date.parse(new Date());
        return {
            'Total': t,
            'Days': Math.floor(t / (1000 * 60 * 60 * 24)),
            'Hours': Math.floor((t / (1000 * 60 * 60)) % 24),
            'Minutes': Math.floor((t / 1000 / 60) % 60),
            'Seconds': Math.floor((t / 1000) % 60)
        };
    }

    function Clock(countdown, callback) {
        countdown = countdown ? new Date(Date.parse(countdown)) : false;
        callback = callback || function() {};

        var updateFn = countdown ? getTimeRemaining : getTime;

        this.el = document.createElement('div');
        this.el.className = 'flip-clock';

        var trackers = {},
            t = updateFn(countdown),
            key, timeinterval;

        for (key in t) {
            if (key === 'Total') { continue; }
            trackers[key] = new CountdownTracker(key, t[key]);
            this.el.appendChild(trackers[key].el);
        }

        var i = 0;
        function updateClock() {
            timeinterval = requestAnimationFrame(updateClock);

            // Throttle so it's not constantly updating the time.
            if (i++ % 10) { return; }

            var t = updateFn(countdown);
            if (t.Total < 0) {
                cancelAnimationFrame(timeinterval);
                for (key in trackers) {
                    trackers[key].update(0);
                }
                callback();
                return;
            }

            for (key in trackers) {
                trackers[key].update(t[key]);
            }
        }

        setTimeout(updateClock, 500);
    }

    // Example usage:
    var deadline = new Date(Date.parse(new Date()) + 12 * 24 * 60 * 60 * 1000);
    var c = new Clock(deadline, function() { alert('Countdown complete') });
    document.getElementById('countdown').appendChild(c.el);
</script>
    <?php endif; ?>
</body>
</html>