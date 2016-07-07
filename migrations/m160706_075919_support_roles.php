<?php

use jarrus90\User\migrations\RbacMigration;

class m160706_075919_support_roles extends RbacMigration {

    public function up() {
        
        $admin = $this->authManager->getRole('admin');
        $adminSuper = $this->authManager->getRole('admin_super');
        $adminSupport = $this->authManager->getRole('admin_support');
        
        $supportAdmin = $this->createRole('support_admin', 'Cms administrator role');
        $supportPublisher = $this->createRole('support_publisher', 'Cms publisher role');
        $this->assignChildRole($supportPublisher, $admin);
        $this->assignChildRole($supportAdmin, $supportPublisher);
        $this->assignChildRole($adminSupport, $supportPublisher);
        $this->assignChildRole($adminSuper, $supportAdmin);
    }

    public function down() {
        
    }

}
