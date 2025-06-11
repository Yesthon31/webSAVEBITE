<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SaveBite Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
    <link rel="icon" href="/images/logoSaveBite.png">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <style>
        :root {
            --primary-green: #4CAF50;
            --light-green: #81C784;
            --white: #ffffff;
            --gray-bg: #f5f5f5;
            --text-dark: #333333;
            --danger: #f44336;
            --warning: #ff9800;
            --success: #4caf50;
            --spacing-xs: 0.5rem;
            --spacing-sm: 1rem;
            --spacing-md: 1.5rem;
            --spacing-lg: 2rem;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--gray-bg);
            color: var(--text-dark);
            margin: 0;
            padding: 0;
            min-height: 100vh;
            overflow-y: hidden;
            display: flex;
            flex-direction: column;
        }

        .main-wrapper {
            flex: 1 0 auto;
            display: flex;
            flex-direction: column;
        }

        .header {
            background: var(--primary-green);
            color: var(--white);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .header h1 {
            font-size: 1.8em;
            margin: 0;
            font-weight: 600;
        }

        .logout-btn {
            background: var(--white);
            color: var(--text-dark);
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 20px;
            cursor: pointer;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            background: #f1f1f1;
            transform: translateY(-2px);
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .main-container {
            flex: 1;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            padding: 2rem;
            max-width: 1400px;
            margin: 0 auto;
            width: 100%;
            box-sizing: border-box;
        }

        .calendar-container {
            background: var(--white);
            border-radius: 10px;
            padding: var(--spacing-md);
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
        }

        .right-panel {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .welcome-card {
            background: var(--white);
            border-radius: 10px;
            padding: var(--spacing-md);
            border-left: 4px solid var(--primary-green);
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
            margin-bottom: var(--spacing-md);
        }

        .welcome-card h2 {
            color: var(--text-dark);
            margin: 0;
            font-size: 1.6em;
            line-height: 1.4;
            }

        .welcome-card h2 strong {
            color: var(--primary-green);
            }

        .welcome-card p {
            margin: var(--spacing-sm) 0 0;
            color: #666;
            font-size: 1.1em;
            line-height: 1.6;
        }   

        .notification-card {
            background: var(--white);
            border-radius: 10px;
            padding: var(--spacing-md);
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
            border-left: 4px solid var(--warning);
            margin-bottom: var(--spacing-md);
            transition: all 0.3s ease;
        }

        .notification-card.has-alerts {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { box-shadow: 0 2px 15px rgba(0,0,0,0.08); }
            50% { box-shadow: 0 2px 20px rgba(255, 152, 0, 0.3); }
            100% { box-shadow: 0 2px 15px rgba(0,0,0,0.08); }
        }

        .notification-card h3 {
            color: var(--warning);
            margin: 0;
            font-size: 1.3em;
            display: flex;
            align-items: center;
            gap: var(--spacing-xs);
        }

        .notification-card h3 i {
            font-size: 1.2em;
        }

        .notification-item {
            display: flex;
            align-items: center;
            padding: var(--spacing-sm) 0;
            border-bottom: 1px solid #eee;
            gap: var(--spacing-sm);
        }

        .notification-item:last-child {
            border-bottom: none;
        }

        .notification-icon {
            font-size: 1.2em;
        }

        .notification-icon.expired {
            color: var(--danger);
        }

        .notification-icon.warning {
            color: var(--warning);
        }

        .notification-content {
            flex: 1;
            font-size: 1em;
            line-height: 1.4;
        }

        .notification-content strong {
            font-weight: 600;
        }

        .action-cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: var(--spacing-md);
        }

        .action-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 1.5rem;
            text-align: center;
            text-decoration: none;
            color: var(--text-dark);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.4);
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.8rem;
        }

        .action-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg,rgb(170, 218, 164, 0.2) 0%, rgba(91, 233, 185, 0.2) 100%);
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .action-card:hover {
            transform: translateY(-8px);
            border-color: rgb(170, 218, 164);
            box-shadow: 
                0 15px 25px rgba(170, 218, 164, 0.2),
                0 0 15px rgba(91, 233, 185, 0.1);
        }

        .action-card:hover::before {
            opacity: 1;
        }

        .action-card i {
            font-size: 2em;
            color: rgb(170, 218, 164);
            transition: all 0.4s ease;
            position: relative;
            background: linear-gradient(90deg,rgb(170, 218, 164) 0%, #5be9b9 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .action-card:hover i {
            transform: scale(1.1) translateY(-5px);
        }

        .action-card h3 {
            margin: 0;
            font-size: 1.2em;
            font-weight: 600;
            color: var(--text-dark);
            transition: color 0.3s ease;
            position: relative;
        }

        .action-card:hover h3 {
            background: linear-gradient(90deg,rgb(170, 218, 164) 0%, #5be9b9 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .tooltip {
            position: absolute;
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 8px 12px;
            border-radius: 4px;
            font-size: 0.9em;
            z-index: 1000;
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        /* Calendar Customization */
        .fc-day-grid-event {
            padding: 6px 8px !important;
            border-radius: 6px !important;
            margin: 2px 4px !important;
            transition: transform 0.2s ease, box-shadow 0.2s ease !important;
        }

        .fc-day-grid-event:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
            cursor: pointer;
        }

        .fc-day-grid-event .fc-content {
            white-space: normal !important;
            overflow: visible !important;
            font-size: 0.9em !important;
            line-height: 1.4 !important;
        }

        .fc-day-grid-event .fc-time {
            font-weight: 600 !important;
        }

        .fc-today {
            background: #E8F5E9 !important;
            border: 2px solid var(--primary-green) !important;
        }

        .fc button {
            height: auto !important;
            padding: 8px 16px !important;
            font-size: 0.9em !important;
            font-weight: 500 !important;
            text-transform: capitalize !important;
            transition: all 0.3s ease !important;
        }

        .fc button:hover {
            background: var(--light-green) !important;
            border-color: var(--light-green) !important;
        }

        .fc-toolbar h2 {
            font-size: 1.5em !important;
            padding: var(--spacing-sm) 0 !important;
        }

        /* Responsive adjustments */
        @media (max-width: 1024px) {
            .main-container {
                grid-template-columns: 1fr;
            }

            .action-cards {
                grid-template-columns: repeat(2, 1fr);
            }

            .fc-day-grid-event .fc-content {
                font-size: 0.85em !important;
            }
        }

        @media (max-width: 768px) {
            :root {
                --spacing-md: 1rem;
                --spacing-lg: 1.5rem;
            }

            .header {
                padding: 1rem;
        }

            .main-container {
                padding: 1rem;
            }

            .action-cards {
                grid-template-columns: 1fr;
            }

            .fc-day-grid-event .fc-content {
                font-size: 0.8em !important;
        }

            .welcome-card h2 {
                font-size: 1.4em;
            }

            .welcome-card p {
                font-size: 1em;
            }
        }

        .footer {
            flex-shrink: 0;
            background: var(--white);
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 -2px 10px rgba(0,0,0,0.05);
            margin-top: auto;
        }

        .footer-content {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .footer-left {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .footer-logo {
            color: var(--primary-green);
            font-weight: 600;
            font-size: 1.2em;
            text-decoration: none;
        }

        .footer-links {
            display: flex;
            gap: 1.5rem;
        }

        .footer-link {
            color: var(--text-dark);
            text-decoration: none;
            transition: color 0.3s ease;
            font-size: 0.9em;
        }

        .footer-link:hover {
            color: var(--primary-green);
        }

        .footer-social {
            display: flex;
            gap: 1rem;
        }

        .social-link {
            color: var(--text-dark);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .social-link:hover {
            color: var(--primary-green);
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .footer-content {
                flex-direction: column;
                text-align: center;
        }

            .footer-links {
                flex-direction: column;
                gap: 0.5rem;
            }

            .footer-social {
                margin-top: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="main-wrapper">
    <div class="header">
        <h1>SaveBite</h1>
            <form action="/logout" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>

        <div class="main-container">
            <div class="calendar-container">
                <div id="calendar"></div>
    </div>

            <div class="right-panel">
                <div class="welcome-card">
                    <h2>Welcome to the <strong>SaveBite Dashboard</strong>!</h2>
                    <p>Track your food inventory, manage expiration dates, and reduce food waste efficiently.</p>
    </div>

                <div class="notification-card">
                    <h3><i class="fas fa-bell"></i> Perhatian!</h3>
                    <div class="notification-content">
                        <!-- Will be populated by JavaScript -->
                    </div>
                </div>
                <div class="action-cards">
                    <a href="{{ url('/recipes') }}" class="action-card" data-tooltip="View your cooking history and saved recipes">
                        <i class="fas fa-history"></i>
                        <h3>History Recipes</h3>
                    </a>
                    <a href="{{ url('/foods/add') }}" class="action-card" data-tooltip="Add new items to your food inventory">
                        <i class="fas fa-plus"></i>
                        <h3>Add New Food</h3>
                    </a>
                    <a href="{{ url('/foods') }}" class="action-card" data-tooltip="View and manage your food inventory">
                        <i class="fas fa-utensils"></i>
                        <h3>View Food Data</h3>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="footer-content">
            <div class="footer-left">
                <a href="/" class="footer-logo">SaveBite</a>
                <span>&copy; 2025 All rights reserved</span>
            </div>
            <div class="footer-links">
                <a href="/about" class="footer-link">About Us</a>
                <a href="/privacy" class="footer-link">Privacy Policy</a>
                <a href="/terms" class="footer-link">Terms of Service</a>
                <a href="/contact" class="footer-link">Contact</a>
            </div>
            <div class="footer-social">
                <a href="#" class="social-link" title="Facebook">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#" class="social-link" title="Twitter">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="#" class="social-link" title="Instagram">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="#" class="social-link" title="LinkedIn">
                    <i class="fab fa-linkedin-in"></i>
                </a>
            </div>
        </div>
    </footer>

    <!-- Layout chat ai -->
    @include('layouts.chat')

    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize tooltips
            $('.action-card').hover(function(e) {
                const tooltip = $('<div class="tooltip"></div>');
                tooltip.text($(this).data('tooltip'));
                $('body').append(tooltip);
                
                const card = $(this);
                const cardOffset = card.offset();
                const tooltipWidth = tooltip.outerWidth();
                
                tooltip.css({
                    top: cardOffset.top - tooltip.outerHeight() - 10,
                    left: cardOffset.left + (card.outerWidth() - tooltipWidth) / 2,
                    opacity: 1
                });
            }, function() {
                $('.tooltip').remove();
            });

            // Calendar initialization with enhanced event rendering
            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                editable: true,
                eventLimit: true,
                height: 'auto',
                contentHeight: 'auto',
                events: fetchEvents,
                themeSystem: 'standard',
                eventColor: '#4CAF50',
                eventTextColor: '#ffffff',
                eventBorderColor: '#388E3C',
                eventRender: function(event, element) {
                    element.css('cursor', 'pointer');
                    
                    // Add hover effect
                    element.hover(function() {
                        $(this).css({
                            transform: 'scale(1.02)',
                            transition: 'transform 0.2s ease'
                        });
                    }, function() {
                        $(this).css('transform', 'scale(1)');
                    });
                }
            });

            function fetchEvents(start, end, timezone, callback) {
                $.ajax({
                    url:'/foods-calender',                   
                    method: 'GET',
                    success: function(data) {
                        if (!Array.isArray(data)) {
                            console.error('Invalid data format received');
                            callback([]);
                            return;
                        }

                        const now = new Date();
                        let notifications = [];
                        let hasExpired = false;

                        const events = data.map(food => {
                            if (!food || !food.expiry_date || !food.name) {
                                return null;
                            }

                            const expiry = new Date(food.expiry_date);
                            if (isNaN(expiry.getTime())) {
                                console.error('Invalid expiry date for food:', food);
                                return null;
                            }

                            const diffDays = Math.floor((expiry - now) / (1000 * 60 * 60 * 24));

                            let color = '#4CAF50'; // Fresh - Green
                            if (diffDays < 0) {
                                color = '#F44336'; // Expired - Red
                                hasExpired = true;
                                notifications.push(`
                                    <div class="notification-item">
                                        <i class="fas fa-times-circle notification-icon expired"></i>
                                        <div class="notification-content">
                                            <strong>${food.name}</strong> has expired ${Math.abs(diffDays)} days ago
                                        </div>
                                    </div>
                                `);
                            } else if (diffDays <= 14) {
                                color = '#FF9800'; // Warning - Orange
                                notifications.push(`
                                    <div class="notification-item">
                                        <i class="fas fa-exclamation-triangle notification-icon warning"></i>
                                        <div class="notification-content">
                                            <strong>${food.name}</strong> will expire in ${diffDays} days
                                        </div>
                                    </div>
                                `);
                            }

                            return {
                                title: food.name,
                                start: food.expiry_date,
                                color: color,
                                borderColor: color,
                                className: 'food-event'
                            };
                        }).filter(event => event !== null);

                        const notifCard = $('.notification-card');
                        const notifContent = notifCard.find('.notification-content');
                        
                        if (notifications.length > 0) {
                            notifContent.html(notifications.join(''));
                            notifCard.addClass('has-alerts');
                            if (hasExpired) {
                                notifCard.css('border-left-color', '#F44336');
                                notifCard.find('h3').css('color', '#F44336');
                            }
                        } else {
                            notifContent.html(`
                                <div class="notification-item">
                                    <i class="fas fa-check-circle notification-icon" style="color: var(--success)"></i>
                                    <div class="notification-content">
                                        No food items expiring soon
                                    </div>
                                </div>
                            `);
                            notifCard.removeClass('has-alerts');
                        }

                        callback(events);
                    }
                });
            }

            // Refresh events every 10 minutes
            setInterval(function() {
                $('#calendar').fullCalendar('refetchEvents');
            }, 600000);
        });
    </script>
</body>
</html>
