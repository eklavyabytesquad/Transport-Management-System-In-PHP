<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!--=============== REMIXICONS ===============-->
        <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">

        <!--=============== CSS ===============-->
        <link rel="stylesheet" href="style.css">

        <title>Responsive navigation bar - Bedimcode</title>
        <style>
    /* Resetting default margin and padding */
   
 .custom-container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 15px;
    }

    .text-center {
      text-align: center;
    }

    .mt-5-custom {
      margin-top: 5rem;
    }

    .mb-4-custom {
      margin-bottom: 4rem;
    }

    .brand-container-custom {
      display: flex;
      overflow: hidden;
      position: relative;
      padding: 20px 0;
    }

    .brand-container-custom .brand-track-custom {
      display: flex;
      align-items: center;
      white-space: nowrap;
      animation: moveLeft 25s linear infinite;
    }

    .brand-container-custom img {
      display: inline-block;
      height: 50px;
      margin-right: 40px;
    }

    @keyframes moveLeft {
      0% {
        transform: translateX(100%);
      }
      100% {
        transform: translateX(-100%);
      }
    }

    .btn-primary-custom {
      display: inline-block;
      background-color: #007bff;
      border: none;
      color: #fff;
      padding: 10px 20px;
      font-size: 16px;
      cursor: pointer;
      border-radius: 5px;
      transition: background-color 0.3s ease, border-color 0.3s ease;
    }

    .btn-primary-custom:hover {
      background-color: #0069d9;
    }
    .unique-container {
      max-width: 1200px;
      margin: 20px auto;
      display: flex;
      flex-wrap: wrap;
      justify-content: space-around;
    }

    .unique-card {
      width: calc(33.33% - 40px);
      margin: 20px;
      padding: 20px;
      border-radius: 10px;
      background-color: #fff;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      transition: box-shadow 0.3s ease;
    }

    .unique-card:hover {
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .unique-card-img {
      width: 100%;
      border-radius: 50%;
    }

    .unique-card-content {
      text-align: center;
      margin-top: 20px;
    }

    .unique-card-content h2 {
      margin-bottom: 10px;
    }

    .unique-card-content p {
      margin-bottom: 20px;
    }

    .unique-btn {
      display: inline-block;
      padding: 10px 20px;
      background-color: #007bff;
      color: #fff;
      text-decoration: none;
      border: none;
      border-radius: 5px;
      transition: background-color 0.3s ease;
    }

    .unique-btn:hover {
      background-color: #0056b3;
    }

    @media screen and (max-width: 768px) {
      .unique-card {
        width: calc(50% - 40px);
      }
    }

    @media screen and (max-width: 576px) {
      .unique-card {
        width: calc(100% - 40px);
      }
    }
    .card-container {
  border: 1px solid #ccc;
  border-radius: 5px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  max-width: 600px;
  margin: 0 auto;
  background-color: #fff;
  transition: box-shadow 0.3s ease;
}

.card-container:hover {
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.card-title {
  background-color: #007bff;
  color: #fff;
  padding: 10px;
  text-align: center;
}

.card-content {
  display: flex;
  align-items: center;
  padding: 20px;
  flex-wrap: wrap;
}

.card-image {
  width: 150px;
  height: 150px;
  border-radius: 50%;
  object-fit: cover;
  margin-right: 20px;
  margin-bottom: 20px;
  transition: transform 0.3s ease;
}

.card-image:hover {
  transform: scale(1.1);
}

.card-quote {
  font-style: italic;
  margin: 0;
  flex: 1;
  color: #555;
}

.card-cite {
  display: block;
  text-align: right;
  margin-top: 10px;
  font-weight: bold;
  color: #333;
}

/* Media query for smaller screens */
@media (max-width: 480px) {
  .card-content {
    flex-direction: column;
    align-items: flex-start;
  }
  .card-container{
    width: calc(100% - 40px);
  }

  .card-image {
    margin-right: 0;
    margin-bottom: 20px;
  }
}
::-webkit-scrollbar{
    width:1rem;
}
::-webkit-scrollbar-track{
    background:#007bff;
    border-radius:7px;
}
::-webkit-scrollbar-thumb{
    background:white;
    border-radius:100vw;
    border: .25rem solid #007bff;
}

  </style>
    </head>
    <body>
        <!--=============== HEADER ===============-->
        <header class="header">
            <nav class="nav container">
                <div class="nav__data">
                    <a href="#" class="nav__logo">
                        <i class="ri-truck-line"></i> SS TRANSPORT
                    </a>
    
                    <div class="nav__toggle" id="nav-toggle">
                        <i class="ri-menu-line nav__toggle-menu"></i>
                        <i class="ri-close-line nav__toggle-close"></i>
                    </div>
                </div>

                <!--=============== NAV MENU ===============-->
                <div class="nav__menu" id="nav-menu">
                    <ul class="nav__list">
                        <li>
                            <a href="#" class="nav__link">ABOUT US</a>
                        </li>

                        <!--=============== DROPDOWN 1 ===============-->
                        <li class="dropdown__item">                      
                            <div class="nav__link dropdown__button">
                                TRACKER<i class="ri-arrow-down-s-line dropdown__arrow"></i>
                            </div>

                            <div class="dropdown__container">
                                <div class="dropdown__content">
                                    <div class="dropdown__group">
                                        <div class="dropdown__icon">
                                            <i class="ri-map-pin-line"></i>
                                        </div>
    
                                        <span class="dropdown__title">TRACK YOUR ORDER</span>
    
                                        <ul class="dropdown__list">
                                            <li>
                                                <a href="homepage\branchfinder.php" class="dropdown__link">branch locator</a>
                                            </li>
                                            
                                        </ul>
                                    </div>
    
                                    <div class="dropdown__group">
                                        <div class="dropdown__icon">
                                            <i class="ri-bill-line"></i>
                                        </div>
    
                                        <span class="dropdown__title">FIND YOUR BILTY</span>
    
                                        <ul class="dropdown__list">
                                            <li>
                                                <a href="#" class="dropdown__link">Development with Flutter</a>
                                            </li>
                                            <li>
                                                <a href="#" class="dropdown__link">Web development with React</a>
                                            </li>
                                            <li>
                                                <a href="#" class="dropdown__link">Backend development expert</a>
                                            </li>
                                        </ul>
                                    </div>
    
                                    <div class="dropdown__group">
                                        <div class="dropdown__icon">
                                            <i class="ri-map-2-line"></i>
                                        </div>
    
                                        <span class="dropdown__title" href="homepage\branchfinder.php">BRANCH DETAIL </span>
    
                                        <ul class="dropdown__list">
                                            <li>
                                                <a href="homepage\branchfinder.php" class="dropdown__link">Branch Details </a>
                                            </li>
                                           
                                        </ul>
                                    </div>
    
                                    <div class="dropdown__group">
                                        <div class="dropdown__icon">
                                            <i class="ri-file-paper-2-line"></i>
                                        </div>
    
                                        <span class="dropdown__title">ROUGH BILL ESTIMATE</span>
    
                                        <ul class="dropdown__list">
                                            <li>
                                                <a href="homepage\valuecalculator.php" class="dropdown__link">Rough Estimate </a>
                                            </li>
                                        
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <!--=============== DROPDOWN 2 ===============-->
                        <li class="dropdown__item">
                            <div class="nav__link dropdown__button">
                            LOCATIONS <i class="ri-arrow-down-s-line dropdown__arrow"></i>
                            </div>

                            <div class="dropdown__container">
                                <div class="dropdown__content">
                                    <div class="dropdown__group">
                                        <div class="dropdown__icon">
                                            <i class="ri-code-line"></i>
                                        </div>
    
                                        <span class="dropdown__title">PINCODE INQUIRY</span>
    
                                        <ul class="dropdown__list">
                                            <li>
                                                <a href="#" class="dropdown__link">Free templates</a>
                                            </li>
                                            <li>
                                                <a href="#" class="dropdown__link">Premium templates</a>
                                            </li>
                                        </ul>
                                    </div>
    
                                    <div class="dropdown__group">
                                        <div class="dropdown__icon">
                                            <i class="ri-download-line"></i>
                                        </div>
    
                                        <span class="dropdown__title">DOWNLOAD LOCATIONS LIST</span>
    
                                        <ul class="dropdown__list">
                                            <li>
                                                <a href="homepage\branchlist.php" class="dropdown__link">LocationList</a>
                                            </li>
                                           
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li>
                            <a href="#" class="nav__link">CONTACT</a>
                        </li>

                        <!--=============== DROPDOWN 3 ===============-->
                        <li class="dropdown__item">                        
                            <div class="nav__link dropdown__button">
                                ENQUIRY<i class="ri-arrow-down-s-line dropdown__arrow"></i>
                            </div>

                            <div class="dropdown__container">
                                <div class="dropdown__content">
                                    <div class="dropdown__group">
                                        <div class="dropdown__icon">
                                            <i class="ri-community-line"></i>
                                        </div>
    
                                        <span class="dropdown__title">CUSTOMER</span>
    
                                        <ul class="dropdown__list">
                                        <li>
                                                <a href="login/enquiry.php" class="dropdown__link">SEND ENQUIRY</a>
                                            </li>
                                        </ul>
                                    </div>
    
                                    <div class="dropdown__group">
                                        <div class="dropdown__icon">
                                            <i class="ri-shield-line"></i>
                                        </div>
    
                                        <span class="dropdown__title">OFFICE </span>
    
                                        <ul class="dropdown__list">
                                            <li>
                                                <a href="login/login.php" class="dropdown__link">SS EMPLOYEES/MANAGER</a>
                                            </li>
                                            <li>
                                                <a href="login/login.php" class="dropdown__link">BOD</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <br><br><br><br><br><br>
        <div class="custom-container text-center mt-5-custom">
    <h1 class="mb-4-custom">Companies That Work With SS TRANSPORT</h1>
    <div class="brand-container-custom">
      <div class="brand-track-custom">
      <a href="https://www.linklocks.com/"> <img src="asset\linklock.png" alt="Brand 1"></a>
        <img src="asset\legal.png" alt="Brand 2">
        <img src="asset\harrison.png" alt="Brand 3">
        <img src="asset\plazalock.png" alt="Brand 4">
        <img src="asset\dawakhana.png" alt="Brand 5">
        <img src="asset\ramson.png" alt="Brand 6">
        <img src="asset\raazi.png" alt="Brand 7">
        <img src="brand8.png" alt="Brand 8">
        <img src="brand1.png" alt="Brand 1">
        <img src="brand2.png" alt="Brand 2">
        <img src="brand3.png" alt="Brand 3">
        <img src="brand4.png" alt="Brand 4">
        <img src="brand5.png" alt="Brand 5">
        <img src="brand6.png" alt="Brand 6">
        <img src="brand7.png" alt="Brand 7">
        <img src="brand8.png" alt="Brand 8">
      </div>
      <div class="brand-track-custom">
      <a href="https://www.linklocks.com/"> <img src="asset\linklock.png" alt="Brand 1"></a>
        <img src="asset\legal.png" alt="Brand 2">
        <img src="asset\harrison.png" alt="Brand 3">
        <img src="asset\plazalock.png" alt="Brand 4">
        <img src="asset\dawakhana.png" alt="Brand 5">
        <img src="asset\ramson.png" alt="Brand 6">
        <img src="asset\raazi.png" alt="Brand 7">
        <img src="brand8.png" alt="Brand 8">
        <img src="brand1.png" alt="Brand 1">
        <img src="brand2.png" alt="Brand 2">
        <img src="brand3.png" alt="Brand 3">
        <img src="brand4.png" alt="Brand 4">
        <img src="brand5.png" alt="Brand 5">
        <img src="brand6.png" alt="Brand 6">
        <img src="brand7.png" alt="Brand 7">
        <img src="brand8.png" alt="Brand 8">
      </div>
    </div>
    <button class="btn-primary-custom btn-lg mt-4">Read Customer Stories</button>
  </div>  

<!--=============== CARDS ===============-->
  <div class="unique-container">
    <div class="unique-card">
      <img class="unique-card-img" src="avatar1.jpg" alt="Feature 1 ">
      <div class="unique-card-content">
        <h2>Card 1 Heading</h2>
        <p>Line 1 description.</p>
        <p>Line 2 description.</p>
        <a href="#" class="unique-btn">Action</a>
      </div>
    </div>
    <div class="unique-card">
      <img class="unique-card-img" src="avatar2.jpg" alt="Feature 2">
      <div class="unique-card-content">
        <h2>Card 2 Heading</h2>
        <p>Line 1 description.</p>
        <p>Line 2 description.</p>
        <a href="#" class="unique-btn">Action</a>
      </div>
    </div>
    <div class="unique-card">
      <img class="unique-card-img" src="avatar3.jpg" alt="Feature 3">
      <div class="unique-card-content">
        <h2>Card 3 Heading</h2>
        <p>Line 1 description.</p>
        <p>Line 2 description.</p>
        <a href="#" class="unique-btn">Action</a>
      </div>
    </div>
  </div>

      <!--=============== ceo card ===============-->
      <div class="card-container">
  <div class="card-title">
    <h2>From CEO's Desk</h2>
  </div>
  <div class="card-content">
    <img src="person.jpg" alt="Person Image" class="card-image">
    <blockquote class="card-quote">
      <p>"We have not only built a company, we also developed a culture among our staff, right from truck drivers to the top management. A sense of responsibility, honesty and dedication is inculcated in each of our team member. This is what makes quality & on-time service possible. SS has given employment to over 20+ employees and our growth & success is attributed to this strong workforce. This coupled with the strong in-house IT would propel the Company to newer growth pinnacles in the days to come."</p>
      <cite class="card-cite">- Mr. Rajeev Singh</cite>
    </blockquote>
  </div>
</div>
<br><br><Br>


        <!--=============== MAIN JS ===============-->
        <script src="script.js"></script>
    </body>
</html>