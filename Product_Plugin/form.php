<div class="hcf_box">
    <style scoped>
    .hcf_box {
        display: grid;
        grid-template-columns: max-content 1fr;
        grid-row-gap: 10px;
        grid-column-gap: 20px;
    }

    .hcf_field {
        display: contents;
    }
    </style>
    <p class="meta-options hcf_field">
        <label for="hcf_author">Price</label>
        <input id="hcf_price" type="text" name="hcf_price"
            value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'hcf_price', true ) ); ?>">
    </p>

    <p class="meta-options hcf_field">
        <label for="hcf_price">SKU</label>
        <input id="hcf_sku" type="number" name="hcf_sku"
            value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'hcf_sku', true ) ); ?>">
    </p>
</div>