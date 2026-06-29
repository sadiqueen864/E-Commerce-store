</div> <style>
    .footer { background: #0f172a; color: #94a3b8; text-align: center; padding: 25px; font-size: 14px; font-weight: 500; border-top: 1px solid #1e293b; margin-top: 50px; transition: background 0.3s; }
    .footer b { color: white; }
    .footer-links { margin-top: 10px; display: flex; justify-content: center; gap: 20px; }
    .footer-links a { color: #64748b; text-decoration: none; transition: 0.2s; }
    .footer-links a:hover { color: #4f46e5; }
</style>

<div class="footer" id="mainFooter">
    <p>&copy; 2026 <span id="footerLogoName" style="color:white; font-weight:bold;">⚡ NovaMarket</span>. All rights reserved. Custom Built CMS Application.</p>
    <div class="footer-links">
        <a href="shop.php">Home</a>
        <a href="about.php">About Us</a>
        <a href="contact.php">Contact Support</a>
    </div>
</div>

<script>
// 1. Live Background Color Changer
function changeBgColor(color) {
    document.body.style.backgroundColor = color;
    localStorage.setItem('customBgColor', color);
}

// 2. Live Navbar Color Changer
function changeNavColor(color) {
    document.getElementById('mainNavbar').style.backgroundColor = color;
    localStorage.setItem('customNavColor', color);
}

// 3. Live Footer Color Changer
function changeFootColor(color) {
    document.getElementById('mainFooter').style.backgroundColor = color;
    localStorage.setItem('customFootColor', color);
}

// 4. Save Logo Name on Live Change
function saveLogoName() {
    const newName = document.getElementById('siteLogo').innerText;
    document.getElementById('footerLogoName').innerText = newName;
    localStorage.setItem('customLogoName', newName);
}

// Page load hote hi user ki pasand shuda settings apply karna
window.onload = function() {
    // Load Saved Colors
    const savedBg = localStorage.getItem('customBgColor') || '#f8fafc';
    const savedNav = localStorage.getItem('customNavColor') || '#ffffff';
    const savedFoot = localStorage.getItem('customFootColor') || '#0f172a';
    
    changeBgColor(savedBg);
    changeNavColor(savedNav);
    changeFootColor(savedFoot);
    
    // Set Pickers Value
    document.getElementById('bgColorPicker').value = savedBg;
    document.getElementById('navColorPicker').value = savedNav;
    document.getElementById('footColorPicker').value = savedFoot;
    
    // Load Saved Logo Name
    const savedLogo = localStorage.getItem('customLogoName');
    if(savedLogo) {
        document.getElementById('siteLogo').innerText = savedLogo;
        document.getElementById('footerLogoName').innerText = savedLogo;
    }
}
</script>

</body>
</html>