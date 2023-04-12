<?php


$messages = [

    // general messages
    'process_success_message' => 'Operation accomplished successfully',
    'successful_process_message' => 'Successful operation',
    'store_success_message' => 'Added successfully',
    'update_success_message' => 'Modified successfully',
    'destroy_success_message' => 'Deleted successfully',

];

// Entity Name => Display Text
$entities = [
    'article' => 'Article',
    'category' => 'Category',
    'contact' => 'Contact',
    'test-taker' => 'Test taker'

];

foreach ($entities as $entity_name => $display_text) {
    $messages[$entity_name . '_store_success_message'] = $display_text . ' has been added successfully';
    $messages[$entity_name . '_update_success_message'] = $display_text . ' has been updated successfully';
    $messages[$entity_name . '_destroy_success_message'] = $display_text . ' has been deleted successfully';
}

return $messages;
