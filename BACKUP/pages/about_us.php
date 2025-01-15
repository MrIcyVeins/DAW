<?php
session_start();
require_once "../database/db_connect.php";

// Include header și navbar
include "../includes/header.php";
include "../includes/navbar.php";
?>

<div class="container mt-5">
    <!-- Titlu principal -->
    <h1 class="mb-4 text-center" style="font-family: 'Times New Roman', serif;">About Us</h1>
    <p class="text-center" style="font-style: italic;">Discover who we are and our mission to bring the world closer to you.</p>

    <!-- Secțiune cu informații generale -->
    <div class="about-us-section my-5 p-4" style="background-color: #f8f8f8; border: 1px solid #ccc; border-radius: 8px;">
        <h2 class="mb-3" style="font-family: 'Georgia', serif; text-transform: uppercase;">Our Mission</h2>
        <p>
            Welcome to EchoNewsMagazine, your trusted source for the latest updates in world news, technology, lifestyle, and culture. 
            We aim to provide accurate, reliable, and timely information to keep you informed about the issues that matter most.
        </p>
        <p>
            Our mission is to bring people closer to the world by offering engaging, diverse, and high-quality content. Whether it’s 
            breaking news, the latest innovations in technology, or cultural insights, we’ve got you covered.
        </p>
    </div>

    <!-- Secțiune cu echipa -->
    <div class="team-section my-5">
        <h2 class="mb-3 text-center" style="font-family: 'Georgia', serif; text-transform: uppercase;">Meet the Team</h2>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <!-- Exemplu membru echipă -->
            <div class="col">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">John Doe</h5>
                        <p class="card-text">Founder & Editor-in-Chief</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Jane Smith</h5>
                        <p class="card-text">Technology Correspondent</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Alex Johnson</h5>
                        <p class="card-text">Lifestyle & Culture Editor</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Secțiune cu valorile și obiectivele -->
    <div class="values-section my-5 p-4" style="background-color: #f8f8f8; border: 1px solid #ccc; border-radius: 8px;">
        <h2 class="mb-3" style="font-family: 'Georgia', serif; text-transform: uppercase;">Our Values</h2>
        <ul>
            <li><strong>Integrity:</strong> We are committed to providing unbiased and accurate news.</li>
            <li><strong>Innovation:</strong> We embrace technology to bring you the latest updates efficiently.</li>
            <li><strong>Diversity:</strong> We celebrate diverse perspectives and stories from around the world.</li>
        </ul>
    </div>

    <!-- Secțiune cu CTA pentru utilizatori -->
    <div class="cta-section text-center my-5">
        <h3>Stay Connected with Us</h3>
        <p>Want to stay updated? <a href="newsletter.php">Subscribe to our newsletter</a> for the latest news and insights!</p>
    </div>
</div>

<?php include "../includes/footer.php"; ?>
