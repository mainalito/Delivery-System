<div class="container-fluid">
    <!-- <div class="card"> -->
        <!-- <div class="card-header bg-warning text-black"> -->
            <br>
            <div class="row">
                <div class="col-md-6">
                <h4>Delivery Details for Order No. <?= $model->ID ?></h4>

                </div>
                <div class="col-md-6">
                <button type="button" class="close" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
                </div>

            </div>
            <br>
            <hr>
        <!-- </div> -->
        <!-- <div class="card-body"> -->
            <div class="timeline">
                <div class="timeline-item">
                    <div class="timeline-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="timeline-content">
                        <h3>ORDER PLACED</h3>
                        <p><?= date('d-m-Y', strtotime($model->confirmed_at)) ?></p>
                    </div>
                </div>
                <?php if ($model->DateAssigned !== null) : ?>
                <div class="timeline-item">
                    <div class="timeline-icon">
                        <i class="fas fa-check-circle"></i>

                    </div>
                    <div class="timeline-content">
                        <h3>PENDING CONFIRMATION</h3>
                        <p><?= date('d-m-Y', strtotime($model->DateAssigned)) ?></p>
                    </div>
                </div>
                <?php endif; ?>
                <?php if ($model->DateConfirmed !== null) : ?>
                <div class="timeline-item">
                    <div class="timeline-icon">
                        <i class="fas fa-check-circle"></i>

                    </div>
                    <div class="timeline-content">
                        <h3>OUT FOR DELIVERY</h3>
                        <p><?= date('d-m-Y', strtotime($model->DateConfirmed)) ?></p>
                    </div>
                </div>
                <?php endif; ?>
                <?php if ($model->DateDelivered !== null) : ?>
                <div class="timeline-item">
                    <div class="timeline-icon">
                        <i class="fas fa-dot-circle"></i>

                    </div>
                    <div class="timeline-content">
                        <h3>DELIVERED</h3>
                        <p><?= date('d-m-Y', strtotime($model->DateDelivered)) ?></p>
                        <p>Your order has been delivered.</p>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>

    <!-- </div> -->
</div>
<style>
    @keyframes bounce {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.2);
    }
}

.timeline-icon {
    animation: bounce 0.6s ease;
}

.timeline {
    border-left: 2px solid #ddd;
    /* Vertical line */
    position: relative;
    padding: 0;
    list-style: none;
}

.timeline-icon {
    position: absolute;
    left: 0;
    top: 0;
    transform: translateX(-50%);
    color: #28a745;
    /* Green color for the check icon */
    font-size: 20px;
    /* Larger icon size */
}

.timeline-item {
    position: relative;
    padding: 20px 0 20px 30px;
    /* Adjust padding to align with the icon */
}

.timeline-content h3 {
    margin: 0;
    font-size: 1.2em;
    /* Adjust the font size as needed */
}

.timeline-content p {
    margin: 0;
    font-size: 0.9em;
    /* Adjust the font size as needed */
}
</style>
<script>
    // Close modal logic
    var closeBtn = document.querySelector('.modal .close');
    closeBtn.onclick = function() {
        var modal = document.getElementById('deliveryDetailsModal');
        modal.style.display = 'none';
    };

    // Rest of your modal logic...
</script>