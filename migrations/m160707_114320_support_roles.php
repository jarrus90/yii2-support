<?php

use jarrus90\User\migrations\RbacMigration;

class m160707_114320_support_roles extends RbacMigration {

    public function up() {
        
        $admin = $this->authManager->getRole('admin');
        $adminSuper = $this->authManager->getRole('admin_super');
        $adminContent = $this->authManager->getRole('admin_content');
        $adminModerator = $this->authManager->getRole('admin_moderator');
        
        $supportAdmin = $this->createRole('support_admin', 'Support administrator role');
        $supportPublisher = $this->createRole('support_publisher', 'Support publisher role');
        $supportModerator = $this->createRole('support_moderator', 'Support moderator role');
        $this->assignChildRole($supportPublisher, $admin);
        $this->assignChildRole($supportModerator, $admin);
        
        $this->assignChildRole($adminContent, $supportPublisher);
        $this->assignChildRole($adminModerator, $supportModerator);
        
        $this->assignChildRole($supportAdmin, $supportPublisher);
        $this->assignChildRole($supportAdmin, $supportModerator);
        $this->assignChildRole($adminSuper, $supportAdmin);
    }

    public function down() {
        
    }

}
