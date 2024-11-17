<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Charity Hospital</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }
        header {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-align: center;
        }
        header h1 {
            margin: 0;
            font-size: 2.5rem;
        }
        nav {
            display: flex;
            justify-content: center;
            background: #333;
        }
        nav a {
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            display: inline-block;
        }
        nav a:hover {
            background-color: #4CAF50;
        }
        .hero {
            text-align: center;
            padding: 50px 20px;
            background-color: #eaf7e9;
        }
        .hero h2 {
            margin: 0 0 20px;
            font-size: 2rem;
        }
        .hero p {
            font-size: 1.2rem;
            margin: 0 0 30px;
        }
        .hero button {
            padding: 10px 20px;
            font-size: 1rem;
            color: white;
            background-color: #4CAF50;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .hero button:hover {
            background-color: #45a049;
        }
        .section {
            padding: 20px;
            text-align: center;
        }
        .section h3 {
            margin: 20px 0;
            font-size: 1.8rem;
        }
        .cards {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
        }
        .card {
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 10px;
            max-width: 300px;
            text-align: center;
        }
        .card img {
            width: 100%;
            border-radius: 10px;
        }
        footer {
            background-color: #333;
            color: white;
            padding: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <header>
        <h1>Charity Hospital</h1>
        <p>Caring for the Community with Compassion</p>
    </header>
    <nav>
        <a href="#about">About Us</a>
        <a href="#services">Services</a>
        <a href="#donate">Donate</a>
        <a href="#contact">Contact</a>
    </nav>

    <div class="hero">
        <h2>Welcome to Charity Hospital</h2>
        <p>Your health is our priority. Together, we make a difference in our community.</p>
        <button onclick="location.href='#donate'">Donate Now</button>
    </div>

    <section id="about" class="section">
        <h3>About Us</h3>
        <p>Charity Hospital is dedicated to providing high-quality medical care to underserved communities. 
        Our mission is to ensure no one goes without the care they need, regardless of their financial situation.</p>
    </section>

    <section id="services" class="section">
        <h3>Our Services</h3>
        <div class="cards">
            <div class="card">
                <img src="https://via.placeholder.com/300x200" alt="General Medicine">
                <h4>General Medicine</h4>
                <p>Comprehensive medical care for all ages.</p>
            </div>
            <div class="card">
                <img src="https://via.placeholder.com/300x200" alt="Surgical Care">
                <h4>Surgical Care</h4>
                <p>Affordable surgical procedures for those in need.</p>
            </div>
            <div class="card">
                <img src="https://via.placeholder.com/300x200" alt="Maternal Care">
                <h4>Maternal Care</h4>
                <p>Supporting mothers and newborns with expert care.</p>
            </div>
        </div>
    </section>

    <section id="donate" class="section">
        <h3>Make a Difference</h3>
        <p>Your generosity helps us provide life-saving medical care to those in need.</p>
        <button onclick="alert('Redirecting to Donation Page!')">Donate Now</button>
    </section>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> Charity Hospital. All rights reserved.</p>
    </footer>
</body>
</html>
