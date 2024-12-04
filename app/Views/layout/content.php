<?= $this->extend('/layout/app') ?>
<?= $this->section('content') ?>

<section class="section">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">About Vertical Navbar</h4>
        </div>
        <div class="card-body">
            <p>Vertical Navbar is a layout option that you can use with Mazer. </p>

            <p>In case you want the navbar to be sticky on top while scrolling, add
                <code>.navbar-fixed</code> class alongside with <code>.layout-navbar</code> class.
            </p>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Dummy Text</h4>
        </div>
        <div class="card-body">
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. In mollis tincidunt tempus. Duis vitae
               
            </p>
            <p>
                Proin accumsan nec arcu sit amet volutpat. Proin non risus luctus, tempus quam quis, volutpat orci.
                Phasellus commodo arcu dui, ut convallis quam sodales maximus. Aenean sollicitudin massa a quam
             
            </p>
            <p>
                In pharetra quam vel lobortis fermentum. Nulla vel risus ut sapien porttitor volutpat eu ac lorem.
                Vestibulum porta elit magna, ut ultrices sem fermentum ut. Vestibulum blandit eros ut imperdiet
               
            </p>
        </div>
    </div>
</section>

<?= $this->endSection() ?>