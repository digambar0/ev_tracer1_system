<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Welcome Page</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Times New Roman', serif;
    }

    body {
      background-image: url('ev.jpg');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      background-attachment: fixed;
    }

    .modal-transition {
      transition: opacity 0.4s ease, transform 0.4s ease;
      transform: scale(0.95);
      opacity: 0;
    }

    .modal-show {
      opacity: 1 !important;
      transform: scale(1) !important;
    }

    @keyframes fadeIn {
      from {
        background-color: rgba(0, 0, 0, 0);
      }
      to {
        background-color: rgba(0, 0, 0, 0.8);
      }
    }

    #aboutSection,
    #contactSection {
      animation: fadeIn 0.3s ease forwards;
    }
  </style>
</head>
<body class="bg-gray-100 text-gray-800 flex flex-col min-h-screen">
  <!-- Header -->
  <header class="bg-gray-900 shadow-md border-b border-white sticky top-0 z-40">
    <div class="container mx-auto px-6 py-4 flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
      <div class="flex items-center space-x-4">
        <img src="logo.jpg" alt="EV Charging Tracer logo" class="h-10 w-10 object-contain rounded-full" />
        <h1 class="text-2xl font-bold text-cyan-400">Ev-Charging Tracer</h1>
      </div>
      <nav class="space-x-4">
        <a href="#" class="px-4 py-2 rounded-md border border-cyan-400 text-white hover:bg-cyan-400 hover:text-gray-900 transition text-sm md:text-base hover:scale-105 hover:shadow-xl">Home</a>
        <a href="javascript:void(0)" onclick="toggleAbout()" class="px-4 py-2 rounded-md border border-cyan-400 text-white hover:bg-cyan-400 hover:text-gray-900 transition text-sm md:text-base hover:scale-105 hover:shadow-xl">About</a>
        <a href="javascript:void(0)" onclick="toggleContact()" class="px-4 py-2 rounded-md border border-cyan-400 text-white hover:bg-cyan-400 hover:text-gray-900 transition text-sm md:text-base hover:scale-105 hover:shadow-xl">Contact</a>
      </nav>
    </div>
  </header>

  <!-- Main Content -->
  <main class="flex-grow flex items-center justify-center px-4 text-center">
    <div>
      <h2 class="text-3xl sm:text-4xl font-bold mb-4 text-white">Ev-Charging Tracer</h2>
      <p class="text-base sm:text-lg text-white mb-6">We are glad to have you here. Explore and enjoy your visit!</p>
      <a href="signupform.php" class="bg-gradient-to-r from-blue-500 via-purple-500 to-blue-500 text-white px-4 sm:px-6 py-2 sm:py-3 rounded-full hover:from-purple-600 hover:to-blue-700 transition duration-500 shadow-lg">Get Started</a>

    </div>
  </main>

  <!-- About Modal -->
  <section id="aboutSection" class="hidden modal-transition fixed inset-0 bg-black bg-opacity-80 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen p-4">
      <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl p-6 sm:p-8 text-gray-800">
        <h2 class="text-2xl font-bold mb-4 text-center">EV Charging Tracer</h2>
        <p class="text-sm leading-relaxed">
          The EV Charging Tracer is a user-friendly web application designed to simplify the EV charging experience by helping owners quickly find available charging stations.<br /><br />
          Offering real-time station availability, smart navigation, user reviews, and integration with multiple charging networks, the app streamlines the process of locating and accessing chargers.<br /><br />
          With features like route optimization and future plans for reservations, it aims to reduce the stress of charging, improve convenience, and support the growing shift towards electric vehicles.<br /><br />
          The goal is to enhance overall EV infrastructure and make EV usage more practical and efficient.
        </p>
        <div class="text-center mt-6">
          <button onclick="toggleAbout()" class="mt-4 px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 hover:scale-105 hover:shadow-xl transition">Close</button>
        </div>
      </div>
    </div>
  </section>

  <!-- Contact Modal -->
  <section id="contactSection" class="hidden modal-transition fixed inset-0 bg-black bg-opacity-80 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg max-w-2xl p-8 text-gray-800">
      <h2 class="text-2xl font-bold mb-4 text-center">Contact Information</h2>
      <table class="w-full text-lg">
        <thead>
          <tr>
            <th class="px-4 py-2 border-b">Name</th>
            <th class="px-4 py-2 border-b">ID</th>
            <th class="px-4 py-2 border-b">Mobile Number</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="px-4 py-2 border-b">AKASH.P</td>
            <td class="px-4 py-2 border-b">02FE23BCA003</td>
            <td class="px-4 py-2 border-b">0123456789</td>
          </tr>
          <tr>
            <td class="px-4 py-2 border-b">ABHAY.B</td>
            <td class="px-4 py-2 border-b">02FE23BCA005</td>
            <td class="px-4 py-2 border-b">0123456789</td>
          </tr>
          <tr>
            <td class="px-4 py-2 border-b">DIGAMBAR.K</td>
            <td class="px-4 py-2 border-b">02FE23BCA018</td>
            <td class="px-4 py-2 border-b">0123456789</td>
          </tr>
          <tr>
            <td class="px-4 py-2 border-b">SOHAIL</td>
            <td class="px-4 py-2 border-b">02FE23BCA043</td>
            <td class="px-4 py-2 border-b">0123456789</td>
          </tr>
        </tbody>
      </table>
      <div class="text-center mt-6">
        <button onclick="toggleContact()" class="mt-4 px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 hover:scale-105 hover:shadow-xl transition">Close</button>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-gray-900 text-white text-center mt-5">
    <div class="container mx-auto px-4 py-4">
      <p class="text-sm sm:text-base mb-1">&copy; <?php echo date("Y"); ?> EV System. All rights reserved.</p>
      <small class="text-xs sm:text-sm">Built with ❤️ for a cleaner future.</small>
    </div>
  </footer>

  <!-- JS Script -->
  <script>
    function toggleAbout() {
      const modal = document.getElementById('aboutSection');
      modal.classList.toggle('hidden');
      setTimeout(() => {
        modal.classList.toggle('modal-show');
      }, 10);
    }

    function toggleContact() {
      const modal = document.getElementById('contactSection');
      modal.classList.toggle('hidden');
      setTimeout(() => {
        modal.classList.toggle('modal-show');
      }, 10);
    }
  </script>
</body>
</html>
