<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once __DIR__ . '/includes/styles.php' ?>
    <title>Reader's Haven --Landing Page</title>
</head>

<body class="lander">
    <header>
        <nav>
            <div class="logo">
                <i class="fas fa-book-open"></i>
            </div>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="./login.php">Login</a></li>
                <li><a href="./register.php">Register</a></li>
            </ul>
            <span class="bar"><i class="fa fa-bars" aria-hidden="true"></i></span>
        </nav>
        <div class="hero">
            <div class="overlay">
                <div>
                    <h1>Reader's Haven</h1>
                    <p class="typing">
                    </p>
                    <a href="./login.php" class="login">Login</a>
                </div>
            </div>
        </div>
    </header>
    <main>
        <section id="about">
            <div class="work">
                <h1>About Reader's Haven</h1>
                <div>
                    <div class="content">
                        <p>At Reader's Haven, we are passionate about fostering a vibrant online community of book
                            enthusiasts and providing a seamless platform for sharing and discovering a vast
                            collection
                            of books. Whether you’re an avid reader, an aspiring writer, or someone who simply
                            appreciates the written word, you’ve come to the right place.</p>
                    </div>
                    <div class="images">
                        <img src="./assets/images/pexels-elif-kaya-15867476.jpg" alt="" loading="lazy">
                    </div>
                </div>
            </div>
            <div class="work">
                <h1>Our Mission</h1>
                <div>
                    <div class="content">
                        <p>Our mission is to create a dynamic online space that connects book lovers from around the
                            world. We believe that knowledge and stories should be easily accessible and freely
                            shared. Through our platform, we aim to promote the love of reading, foster creativity,
                            and build a community where people can come together to explore, appreciate, and discuss
                            books.</p>
                    </div>
                    <div class="images two">
                        <img src="./assets/images/mission.svg" alt="" class="svg" loading="lazy">
                    </div>
                </div>
            </div>
        </section>
        <section id="curator">
            <h1>Become A Curator</h1>
            <div class="content">
                <p>As book curators on our book-sharing website, you play a vital role in shaping and
                    enriching our digital library. Your contributions are essential in creating a dynamic
                    and diverse collection of books for our community of readers to enjoy. Here’s what you
                    are expected to do as an book curator:
                <dl>
                    <dt>Upload Books:</dt>
                    <dd>You have the privilege to upload books to our platform. Share your favorite reads,
                        literary discoveries, and must-read titles with our community. By uploading books,
                        you
                        expand our collection and introduce readers to new authors, genres, and
                        perspectives.</dd>
                </dl>
                <dl>
                    <dt>Provide Book Information:</dt>
                    <dd>Ensure that the books you upload are accompanied by accurate and comprehensive
                        information. Include details such as the book title, author, genre, synopsis, and
                        any
                        other relevant details that can help readers make informed choices.</dd>
                </dl>
                <dl>
                    <dt>Maintain Quality Standards:</dt>
                    <dd> As a book curator, you are responsible for maintaining the quality standards of our
                        digital library. Ensure that the books you upload are of good quality, free from
                        errors,
                        and meet our content guidelines. Your efforts help create a reliable and enjoyable
                        reading experience for our community.</dd>
                </dl>
                </p>
                <a href="./admin/login.php">Start</a>
            </div>
        </section>
    </main>
    <footer>
        <section>
            <div class="wrapper">
                <h4>Quicklinks</h4>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="./login.php">Login</a></li>
                    <li><a href="./login.php">Register</a></li>
                    <li><a href="./admin/register.php">Become a curator</a></li>
                </ul>
            </div>
            <div class="wrapper">
                <h4>App Description</h4>
                <p>At Reader's Haven, we believe in the power of sharing and collaboration when it comes to
                    literature. Our platform thrives on the passion and expertise of our dedicated Contributors,
                    who play a crucial role in expanding our extensive book collection.</p>
            </div>
            <div class="wrapper">
                <h4>Contact Developer</h4>
                <ul>
                    <li><a href="https://habeeb4shittu.github.io/portfolio">Portfolio</a></li>
                    <li><a href="mailto:habeeb4shittu@gmail.com">habeeb4shittu@gmail.com</a></li>
                    <li><a href="tel:09166852821">Call</a></li>
                </ul>
                <div class="icos">
                    <a href="https://www.linkedin.com/in/habeeb-shittu-5a013824b" target="_blank">
                        <i class="fab fa-linkedin soc" aria-hidden="true"></i>
                    </a>
                    <a href="https://web.facebook.com/profile.php?id=100080684107038" target="_blank">
                        <i class="fab fa-facebook soc" aria-hidden="true"></i>
                    </a>
                    <a href="https://twitter.com/HabeebAdedolapo" target="_blank">
                        <i class="fab fa-twitter soc" aria-hidden="true"></i>
                    </a>
                    <a href="https://github.com/habeeb4shittu" target="_blank">
                        <i class="fab fa-github soc" aria-hidden="true"></i>
                    </a>
                    <a href="https://wa.me/message/AQMDXR7LYQSTF1" target="_blank">
                        <i class="fab fa-whatsapp soc" aria-hidden="true"></i>
                    </a>
                    <a href="https://www.instagram.com/habeebadedolapo4/" target="_blank">
                        <i class="fab fa-instagram soc" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </section>
        <p class="copyright">
            &copy;copyright Halbion<i class="fab fa-dev"></i>
            <i>v1.2.1</i>
        </p>
    </footer>
    <?php require_once __DIR__ . '/includes/scripts.php' ?>
</body>

</html>