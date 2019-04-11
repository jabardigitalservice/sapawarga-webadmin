import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { AuthGuard } from './guards/auth.guard';

const routes: Routes = [
  { path: 'login', loadChildren: './pages/login/login.module#LoginPageModule' },
  { path: '', loadChildren: './tabs/tabs.module#TabsPageModule' },
  { path: 'about', loadChildren: './pages/about/about.module#AboutPageModule' },
  {
    path: 'edit-profile',
    loadChildren:
      './pages/edit-profile/edit-profile.module#EditProfilePageModule'
  },
  {
    path: 'home-results',
    // canActivate: [AuthGuard],
    loadChildren:
      './pages/home-results/home-results.module#HomeResultsPageModule'
  },
  {
    path: 'view-profile',
    loadChildren:
      './pages/view-profile/view-profile.module#ViewProfilePageModule'
  },
  {
    path: 'nomor-penting',
    loadChildren:
      './pages/nomor-penting/nomor-penting.module#NomorPentingPageModule'
  },
  {
    path: 'nomor-penting/:id',
    loadChildren:
      './pages/detail-nomor-penting/detail-nomor-penting.module#DetailNomorPentingPageModule'
  }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule {}
