<?php include('header.php'); ?>

<div class="info-container">
    <h2>📬 Contact Our Support Team</h2>
    <p>Have a question about an order or need tech advice? Send us a message and our team will get back to you within 24 hours.</p>
    
    <form action="#" method="POST" onsubmit="alert('Thank you! Your message has been sent successfully.'); return false;">
        <div class="form-group">
            <label>Full Name</label>
            <input type="text" placeholder="e.g. Sadia Khan" required>
        </div>
        <div class="form-group">
            <label>Email Address</label>
            <input type="email" placeholder="name@example.com" required>
        </div>
        <div class="form-group">
            <label>Your Message</label>
            <textarea rows="5" placeholder="Write your concern here..." required></textarea>
        </div>
        <button type="submit" class="btn-submit">Send Message</button>
    </form>
</div>

<?php include('footer.php'); ?>