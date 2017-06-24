<?php
  namespace Metatavu\Pakkasmarja\QuestionGroups;
  
  if (!defined('ABSPATH')) { 
    exit;
  }
  
  if (!class_exists( '\Metatavu\Pakkasmarja\QuestionGroups\GroupsWidget' ) ) {
    
    class GroupsWidget {
      
      public function __construct() {
        add_action ('add_meta_boxes', [$this, 'addMetaBoxes'], 9999, 2 );
        add_action ('save_post', [$this, 'saveUserGroups']);
      }
      
      public function addMetaBoxes() {
        $metaboxTitle = __('User Groups', 'pakkasmarja_management');
        
      	add_meta_box('question-group-properties-meta-box', $metaboxTitle, [$this, 'renderQuestionGroupMetaBox'], 'question-group', 'normal', 'default');
      }
      
      public function renderQuestionGroupMetaBox($questionGroup) {
        $userGroupIdOptions = get_post_meta($questionGroup->ID, "pm-user-group-options", true);
        $apiClient = new \Metatavu\Pakkasmarja\Api\ApiClient();
        
        $userGroupsResponse = $apiClient->listUserGroups();
        if ($userGroupsResponse['ok']) {
          $userGroupIds = [];
          
          foreach ($userGroupsResponse['json'] as $userGroup) {
            $userGroupId = $userGroup['id'];
            $this->renderUserGroupField($userGroup['name'], 'user-group-' . $userGroupId, $userGroupIdOptions[$userGroupId]);
            $userGroupIds[] = $userGroup['id'];
          }
          
          echo sprintf('<input name="user-group-ids" id="user-group-ids" type="hidden" value="%s"/>', implode(',', $userGroupIds));
        } else {
          // TODO: Handle error
        }
      }
      
      public function saveUserGroups($questionGroupId) {
        $userGroupIds = \explode(',', filter_input(INPUT_POST, 'user-group-ids'));
        $userGroupIdOptions = [];
        
        foreach ($userGroupIds as $userGroupId) {
          $keyId = sprintf('user-group-%s', $userGroupId);
          $keyRole = sprintf('user-group-%s-role', $userGroupId);
          
          $role = filter_input(INPUT_POST, $keyRole);
          $userGroupIdOptions[$userGroupId] = [
            "allowed" => filter_input(INPUT_POST, $keyId) === "true",
            "role" => $role
          ];
        }
        
        update_post_meta($questionGroupId, 'pm-user-group-options', $userGroupIdOptions);
      }
      
      private function renderUserGroupField($title, $name, $userGroupOptions) {
        $userRoleLabel = __('User', 'pakkasmarja_management');
        $managerRoleLabel = __('Manager', 'pakkasmarja_management');
        $allowed = isset($userGroupOptions) ? $userGroupOptions['allowed'] === true : false;
        $role = isset($userGroupOptions) ? $userGroupOptions['role'] : 'user';
        
      	echo "<p>";
      	echo sprintf('<input name="%s" id="%s" type="checkbox" value="true"%s/>&nbsp;', $name, $name, $allowed ? ' checked="checked"' : '');
      	echo sprintf('<label for="%s">%s</label>',  $name, $title);
        echo sprintf('<select name="%s-role" style="float:right">', $name);
        echo sprintf('<option value="user"%s>%s</option>', $role === 'user' ? ' selected="selected"': '', $userRoleLabel);
        echo sprintf('<option value="manager"%s>%s</option>', $role === 'manager' ? ' selected="selected"': '', $managerRoleLabel);
        echo '</select>';
      	echo "</p>";
      }
      
    }
  
  }
  
  add_action('init', function () {
    new GroupsWidget();
  });
  
?>