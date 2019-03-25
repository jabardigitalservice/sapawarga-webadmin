import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { Routes, RouterModule } from '@angular/router';

import { IonicModule } from '@ionic/angular';

import { ViewProfilePage } from './view-profile.page';

// component
import { MenuNavbarComponent } from '../../components/menu-navbar/menu-navbar.component';

const routes: Routes = [
  {
    path: '',
    component: ViewProfilePage
  }
];

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    RouterModule.forChild(routes)
  ],
  // entryComponents: [MenuNavbarComponent],
  declarations: [ViewProfilePage]
})
export class ViewProfilePageModule {}
