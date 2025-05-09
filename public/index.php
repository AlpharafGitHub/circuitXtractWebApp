<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Welcome | CircuitXtract</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <style>
    /* Reset & base */
    * {
      margin: 0; padding: 0; box-sizing: border-box;
      font-family: Arial, sans-serif;
    }
    body, html {
      height: 100%;
      background: radial-gradient(circle, #8E8E93, #48484A, #2C2C2E);
      color: #fff;
      padding-top: 70px; /* space for header */
    }

    /* Header */
    .site-header {
      position: fixed; top: 0; left: 0; right: 0;
      height: 60px;
      background: rgba(28,28,30,0.95);
      display: flex; align-items: center;
      justify-content: space-between;
      padding: 0 20px; z-index: 1000;
    }
    .nav-menu a {
      margin: 0 15px;
      color: #fff; text-decoration: none;
      font-weight: bold; transition: color 0.2s;
    }
    .nav-menu a:hover { color: #4EC5F1; }
    .auth-links a { margin-left: 10px; }

    /* Buttons */
    .btn {
      padding: 8px 16px; border-radius: 5px;
      text-decoration: none; font-weight: bold;
      transition: background 0.3s;
    }
    .btn-login { background: #4EC5F1; color: #1C1C1E; }
    .btn-login:hover { background: #7acae0; }
    .btn-signup { background: #52cb78; color: #fff; }
    .btn-signup:hover { background: #21b550; }

    /* Sections */
    section {
      padding: 60px 20px;
      max-width: 1000px; margin: 0 auto;
      text-align: center;
    }
    section h2 {
      font-size: 2.5rem; margin-bottom: 20px;
    }
    section p {
      font-size: 1.1rem; line-height: 1.6;
      color: #ddd; margin-bottom: 30px;
    }

    /* Home */
    #home img {
      max-width: 100%; border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.3);
      margin-top: 20px;
    }

    /* About */
    #about .profiles {
      display: flex; gap: 20px;
      flex-wrap: wrap; justify-content: center;
    }
    .profile-card {
      position: relative;
      display: flex;                
      flex-direction: column;       /* stack image → name → role → bio */
      align-items: center;
      width: 300px;                 
      padding: 30px 20px 40px;
      background: rgba(255,255,255,0.1);
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 8px 24px rgba(0,0,0,0.4);
      backdrop-filter: blur(10px);
      transition: transform 0.3s;
    }

    /* subtle hover pop */
    .profile-card:hover {
      transform: translateY(-8px);
    }

    /* gradient overlay */
    .profile-card::before {
      content: "";
      position: absolute;
      top: -50%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: rgba(255,255,255,0.1);
      transform: rotate(25deg);
      pointer-events: none;
      mix-blend-mode: overlay;
    }

    /* Avatar styling */
    .profile-card .profile-img {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      object-fit: cover;
      border: 4px solid #fff;
      box-shadow: 0 4px 12px rgba(0,0,0,0.3);
      margin-bottom: 15px;
    }

    /* Name */
    .profile-card h3 {
      font-size: 1.5rem;
      margin-bottom: 5px;
      color: #fff;
      text-shadow: 0 2px 4px rgba(0,0,0,0.5);
    }

    /* Role */
    .profile-card small {
      font-size: 1rem;
      color: #ddd;
      margin-bottom: 15px;
    }

    /* Bio */
    .profile-card p {
      font-size: 0.9rem;
      line-height: 1.4;
      color: #eee;
      text-align: center;
      max-width: 260px;
    }
    /* Contacts */
    #contacts .contact-list {
      list-style: none; padding: 0;
      display: inline-block; text-align: left;
    }
    #contacts .contact-list li {
      margin: 10px 0; font-size: 1rem;
    }
    #contacts .contact-list i {
      width: 20px; color: #4EC5F1;
      margin-right: 8px;
    }
    #contacts .contact-list a {
      color: #fff; text-decoration: none;
    }
    #contacts .contact-list a:hover {
      text-decoration: underline;
    }

    /* Media */
    @media(max-width:768px) {
      #about .profiles { flex-direction: column; }
      .site-header {
        flex-direction: column; height: auto; padding: 10px;
      }
      body { padding-top: 120px; }
    }
  </style>
</head>
<body>

  <!-- Sticky Header -->
  <header class="site-header">
    <nav class="nav-menu">
      <a href="#home">Home</a>
      <a href="#about">About</a>
      <a href="#contacts">Contacts</a>
    </nav>
    <div class="auth-links">
      <a href="\CircuitXtract\public\login.php" class="btn btn-login">Login</a>
      <a href="\CircuitXtract\public\signup.php" class="btn btn-signup">Sign Up</a>
    </div>
  </header>

  <!-- Home Section -->
  <section id="home">
    <h2>PCB Component Detection</h2>
    <p>
      We designed and implemented a deep learning–based system to detect
      and assess the value of electronic components on printed circuit
      boards (PCBs), promoting sustainable e-waste management in the
      Philippines. Our solution evaluates YOLOv8, RTMDet, and RT-Detr
      models—finally selecting YOLOv8 for its optimal inference time and
      low compute needs—to power a real‐time web application that estimates
      recovery value and supports eco-friendly recycling.
    </p>
    <img src="\CircuitXtract\public\assets\images\circuixtract_1.png" alt="Project Mockup" />
  </section>

  <!-- About Us Section -->
  <section id="about">
    <h2>About Us</h2>
    <div class="profiles">
      <div class="profile-card">
        <img src="\CircuitXtract\public\assets\images\rafael_1.png" alt="Rafael Eugenio" class="profile-img"/>
        <h3>Rafael Eugenio</h3>
        <small>CPE | Intelligent Systems</small>
        <p>
          “I advocate for harnessing data and emerging AI to build sustainable
          solutions—turning raw information into actionable environmental impact.”
        </p>
      </div>
      <div class="profile-card">
        <img src="\CircuitXtract\public\assets\images\alven_2.jpg" alt="Alven Toraja" class="profile-img"/>
        <h3>Alven Toraja</h3>
        <small>CPE | System Administration</small>
        <p>
          “I champion robust system administration practices to ensure
          reliable, scalable platforms—empowering green tech with rock-solid
          infrastructure.”
        </p>
      </div>
    </div>
  </section>

  <!-- Contacts Section -->
  <section id="contacts">
    <h2>Contact Us</h2>
    <ul class="contact-list">
      <li>
        <i class="fas fa-envelope"></i>
        <a href="mailto:qrreugenio@tip.edu.ph">qrreugenio@tip.edu.ph</a>
      </li>
      <li>
        <i class="fas fa-envelope"></i>
        <a href="mailto:qagtoraja@tip.edu.ph">qagtoraja@tip.edu.ph</a>
      </li>
      <li>
        <i class="fab fa-linkedin"></i>
        <a href="https://www.linkedin.com/in/engineerrafael/" target="_blank">
          Rafael’s LinkedIn
        </a>
      </li>
      <li>
        <i class="fab fa-linkedin"></i>
        <a href="https://www.linkedin.com/in/alven-toraja-b411a82a9/" target="_blank">
          Alven’s LinkedIn
        </a>
      </li>
    </ul>
  </section>
</body>
</html>