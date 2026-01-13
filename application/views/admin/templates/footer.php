            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <script src="<?= base_url('assets/js/admin/main.js') ?>"></script>

    <?php if (isset($page_js)): ?>
        <script src="<?= base_url('assets/js/admin/' . $page_js) ?>"></script>
    <?php endif; ?>
</body>
</html>
