<?= $this->extend('template/index'); ?>

<?= $this->section('page-content'); ?>
<div class="container mt-4 mb-5">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4 text-primary">
                <i class="fas fa-bell me-2"></i> Notifikasi
            </h2>

            <?php if (empty($notifikasi)) : ?>
                <div class="alert alert-info">
                    <i class="fas fa-info me-2"></i> Belum ada notifikasi
                </div>
            <?php else : ?>
                <div class="list-group">
                    <?php foreach ($notifikasi as $notif) : ?>
                        <div class="list-group-item list-group-item-action <?= $notif['is_read'] ? '' : 'fw-bold bg-light' ?>"
                             data-id="<?= $notif['id'] ?>">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1"><?= esc($notif['judul']) ?></h5>
                                <small><?= date('d M Y H:i', strtotime($notif['created_at'])) ?></small>
                            </div>
                            <p class="mb-1"><?= esc($notif['pesan']) ?></p>
                            <?php if ($notif['link']) : ?>
                                <a href="<?= base_url($notif['link']) ?>" class="btn btn-sm btn-primary mt-2">
                                    <i class="fas fa-arrow"></i> Lihat Detail
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.list-group-item').forEach(item => {
        item.addEventListener('click', function() {
            const notifId = this.dataset.id;
            if (!this.classList.contains('fw-bold')) return;

            fetch(`<?= base_url('notifikasi/markAsRead/') ?>${notifId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.classList.remove('fw-bold', 'bg-light');
                        updateNotificationCount();
                    }
                });
        });
    });
});

// Update badge notifikasi
function updateNotificationCount() {
    fetch('<?= base_url('notifikasi/getUnreadCount') ?>')
        .then(response => response.json())
        .then(data => {
            const badge = document.querySelector('#notif-badge');
            if (badge) {
                if (data.count > 0) {
                    badge.textContent = data.count;
                    badge.classList.remove('d-none');
                } else {
                    badge.classList.add('d-none');
                }
            }
        });
}
</script>
<?= $this->endSection(); ?>