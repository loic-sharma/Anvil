<div class="span4">
  <div class="well">
    <h3>Links</h3>

    {{ $navigation->links('sidebar') }}

    <h3>Information</h3>
    <p>Load time: {{ $page->loadTime() }} seconds.</p>
  </div>
</div>