<?php
$this->script = '/assets/js/edit.js';
?>

<div id="edit-form" class="edit-form">
  <form ref="form" action="<?php echo $this->formAction ?>" method="post" v-on:submit.prevent="submitForm">
    <div class="form-group">
      <input
        ref="username"
        v-model="username"
        :class="{'is-invalid': errors.username}"
        type="text"
        class="form-control"
        placeholder="Name"
        required="required"
        data-value="<?php echo $this->task['username'] ?? '' ?>"
      >
      <small v-if="errors.username" class="text-danger">{{ errors.username }}</small>
    </div>
    <div class="form-group">
      <input
        ref="email"
        v-model="email"
        :class="{'is-invalid': errors.email}"
        type="text"
        class="form-control"
        placeholder="Email"
        required="required"
        data-value="<?php echo $this->task['email'] ?? '' ?>"
      >
      <small v-if="errors.email" class="text-danger">{{ errors.email }}</small>
    </div>
    <div class="form-group">
      <textarea
        ref="description"
        v-model="description"
        :class="{'is-invalid': errors.description}"
        class="form-control"
        placeholder="Task"
        required="required"
        data-value="<?php echo $this->task['description'] ?? '' ?>"
      ></textarea>
      <small v-if="errors.description" class="text-danger">{{ errors.description }}</small>
    </div>
    <?php if ($this->isAuth): ?>
      <div class="form-group">
        <label for="status">Status</label>
        <select
          ref="status"
          v-model="status"
          id="status"
          class="form-control"
          data-value="<?php echo $this->task['status'] ?>"
        >
          <?php foreach ($this->statuses as $value => $status): ?>
            <option value="<?php echo $value ?>"><?php echo $status ?></option>
          <?php endforeach ?>
        </select>
      </div>
      <?php endif ?>
    <div class="form-group text-right">
      <button id="edit-btn" type="submit" class="btn btn-primary" :class="{ disabled: loading }">Save</button>
    </div>
  </form>
</div>
