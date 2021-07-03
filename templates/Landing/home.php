<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category[]|\Cake\Collection\CollectionInterface $categories
 * @var \App\Model\Entity\Photo[]|\Cake\Collection\CollectionInterface $photos
 */

$this->Paginator->setTemplates([
    'prevActive' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>',
    'prevDisabled' => '<li class="page-item disabled"><a class="page-link" href="{{url}}">{{text}}</a></li>',
    'number' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>',
    'current' => '<li class="page-item active"><a class="page-link" href="{{url}}">{{text}}</a></li>',
    'nextActive' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>',
    'nextDisabled' => '<li class="page-item disabled"><a class="page-link" href="{{url}}">{{text}}</a></li>'
]);
?>

<div class="small-container">
    <h1 class="text-center mt-5 pb-4 border-bottom border-4">All Photos</h1>
    <br>
    <div class="d-flex flex-row justify-content-start mb-4">
        <h4 class="m-0">Categories:</h4>
        <button class="btn btn-primary ms-4" onclick="reloadPhotoByCategory(null)">All</button>
        <?php foreach ($categories as $category): ?>
            <button class="btn btn-primary ms-2" onclick="reloadPhotoByCategory(<?= $category->id ?>)"><?= $category->name ?></button>
        <?php endforeach; ?>
    </div>
    <br>
    <div id="photos" class="row">
        <?php if ($photos->count() == 0): ?>
            <br>
            <h4 class="text-center">There are no photos matching this category currently</h4>
        <?php else: ?>
            <?php foreach ($photos as $photo): ?>
                <div class="col-6 col-md-3">
                    <?= $this->Html->link(
                        $this->Html->image(WATERMARK_PHOTO_PATH . '/' . $photo->file_name, ['class' => 'w-100']),
                        'img' . '/' . WATERMARK_PHOTO_PATH . '/' . $photo->file_name,
                        ['escape' => false, 'data-lightbox' => 'gallery',
                            'data-title' => $photo->description . '<br>' . 'Resolution:' . $photo->res_width . 'x' .  $photo->res_height]) ?>
                    <h4 class="mb-1"><?= $photo->name ?></h4>
                    <p class="m-auto">
                        <?php
                        if (!is_null($photo->discount_price) and $photo->price > $photo->discount_price) {
                            $discount_percent = round((1 - ($photo->discount_price / $photo->price)) * 100);
                            echo '<s>$' . $this->Number->precision($photo->price, 2) . '</s>'
                                . ' $' . $this->Number->precision($photo->discount_price, 2) . ' <b>' . $discount_percent . '% OFF!! </b>';
                        } else {
                            echo '$' . $this->Number->precision($photo->price, 2);
                        }
                        ?>
                    </p>
                    <p class="mb-2"><?= ucfirst($photo->category->name) ?></p>
                    <button class="btn btn-primary mb-4" onclick="addToCart(<?= $photo->id ?>)">Add to Cart</button>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<br><br>

<ul class="pagination justify-content-center">
    <?= $this->Paginator->prev('< ' . __('Previous'), ['class' => 'page-link']) ?>
    <?= $this->Paginator->numbers() ?>
    <?= $this->Paginator->next(__('Next') . ' >') ?>
</ul>

<br><br>

<script type="text/javascript">
    document.addEventListener("contextmenu", (e) => {
        if (e.target.nodeName === "IMG") {
            e.preventDefault();
            alert("Copying images is disabled for this page.");
        }
    });

    function reloadPhotoByCategory(categoryId) {
        let xhr = new XMLHttpRequest();

        xhr.onload = function () {
            /* Parse JSON response */
            const photosJson = JSON.parse(this.responseText);

            /* Clear all photos inside the div */
            const photosDiv = document.getElementById("photos");
            photosDiv.innerHTML = ''

            if (photosJson.photos.length === 0) {
                photosDiv.innerHTML = '<h4 class="text-center">There are no photos matching this category currently</h4>'
            } else {
                /* Re-construct the photo list using DOM */
                for (let i = 0; i < photosJson.photos.length; ++i) {
                    const column = document.createElement('div');
                    column.className = "col-3";

                    const image = document.createElement('img');
                    image.src = "/img/<?= WATERMARK_PHOTO_PATH ?>/" + photosJson.photos[i].file_name;
                    image.className = 'w-100';

                    const imageAnchor = document.createElement('a');
                    imageAnchor.href = "/img/<?= WATERMARK_PHOTO_PATH ?>/" + photosJson.photos[i].file_name;
                    imageAnchor.setAttribute('data-lightbox', 'gallery');
                    imageAnchor.setAttribute('data-title', `${photosJson.photos[i].name}<br>Resolution: ${photosJson.photos[i].res_width}x${photosJson.photos[i].res_height}`);
                    imageAnchor.appendChild(image);
                    column.appendChild(imageAnchor);

                    const name = document.createElement('h4');
                    name.className = 'mb-1';
                    name.innerText = photosJson.photos[i].name;
                    column.appendChild(name);

                    const price = document.createElement('p');
                    price.className = 'mb-auto';
                    if (photosJson.photos[i].discount_price === null) {
                        price.innerText = '$' + photosJson.photos[i].price.toFixed(2);
                    } else {
                        const originalPrice = document.createElement('s');
                        originalPrice.innerText = '$' + photosJson.photos[i].price.toFixed(2);
                        price.appendChild(originalPrice);

                        price.append(' $' + photosJson.photos[i].discount_price.toFixed(2));

                        const discountPercentage = document.createElement('b');
                        discountPercentage.innerText = ` ${((1.00 -
                            photosJson.photos[i].discount_price / photosJson.photos[i].price) * 100).toFixed(0)}% OFF!!`;
                        price.appendChild(discountPercentage);
                    }
                    column.appendChild(price);

                    const categoryName = document.createElement('p');
                    categoryName.className = 'mb-2';
                    categoryName.innerText = photosJson.photos[i].category.name;
                    column.appendChild(categoryName);

                    const addToCartButton = document.createElement('button');
                    addToCartButton.className = 'btn btn-primary mb-4';
                    addToCartButton.innerText = 'Add to Cart';
                    addToCartButton.setAttribute('onclick', `addToCart(${photosJson.photos[i].id})`);
                    column.appendChild(addToCartButton);

                    photosDiv.appendChild(column);
                }
            }
        };

        xhr.open('GET', `/landing/home${categoryId === null ? '' : `/${categoryId}`}.json`);
        xhr.send();
    }

    function addToCart(photoId) {
        const xhr = new XMLHttpRequest();

        xhr.onload = function() {
            const statusJson = JSON.parse(this.responseText);
            const photosRow = document.getElementById('photos');

            const flashDiv = document.createElement('div');
            flashDiv.className = statusJson.ok === true ? 'alert alert-success' : 'alert alert-danger'
            flashDiv.innerText = statusJson.ok === true ?
                'The photo has been added to the shopping cart!' : 'The photo is already in the cart!';
            flashDiv.setAttribute('onclick', "this.classList.add('hidden');");

            photosRow.prepend(flashDiv);
            setTimeout(_ => { flashDiv.remove(); }, 2000);
        };

        xhr.open('GET', `/landing/add-to-cart/${photoId}`);
        xhr.send();
    }
</script>
