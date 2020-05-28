<select multiple name="permission[]" class="form-control listbox">
    <?php
    if ($permissions) {
        foreach ($permissions->result() as $perm) {
            echo '<option value="' . $perm->id . '" ' . (in_array($perm->id, $perm_exist) ? 'selected' : '') . '>' . ($perm->definition ? $perm->definition : $perm->name) . '</option>';
        }
    }
    ?>
</select>
<script type="text/javascript">
    $(document).ready(function () {
        $('.listbox').bootstrapDualListbox();
    })
</script>