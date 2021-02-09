<?php echo "<?php " ?>
return [
@foreach($module as $item)
    "{{$item->orig_lang}}"=>"{{$item->trans_lang}}",
@endforeach
];
