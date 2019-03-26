import { Component, OnInit } from '@angular/core';
import {
  NavController,
  LoadingController,
  ToastController
} from '@ionic/angular';
import { ProfileService } from 'src/app/services/profile.service';
import { FormGroup, FormBuilder, Validators, NgForm } from '@angular/forms';

@Component({
  selector: 'app-edit-profile',
  templateUrl: './edit-profile.page.html',
  styleUrls: ['./edit-profile.page.scss']
})
export class EditProfilePage implements OnInit {
  onEditForm: FormGroup;

  constructor(
    public navCtrl: NavController,
    public loadingCtrl: LoadingController,
    public toastCtrl: ToastController,
    private profileService: ProfileService,
    private formBuilder: FormBuilder
  ) {}

  ngOnInit() {
    this.onEditForm = this.formBuilder.group({
      name: [null, Validators.required],
      email: [null, Validators.required],
      phone: [null, Validators.required],
      address: [null, Validators.required],
      kabkota: [2, Validators.required],
      kecamatan: [null, Validators.required],
      kelurahan: [null, Validators.required],
      rw: [null, Validators.required],
      role: [null, Validators.required],
      instagram: [''],
      facebook: [''],
      twitter: ['']
    });
  }

  ionViewDidEnter() {
    this.profileService.getProfile().subscribe(
      res => {
        console.log(res);
      },
      err => {
        console.log(err);
      }
    );
  }

  onFormSubmit(form: NgForm) {
    console.log(form);
    this.profileService.editProfile(form).subscribe(
      res => {
        console.log(res);
      },
      err => {
        console.log(err);
      }
    );
  }

  async sendData() {
    const loader = await this.loadingCtrl.create({
      duration: 2000
    });

    loader.present();
    loader.onWillDismiss().then(async l => {
      const toast = await this.toastCtrl.create({
        showCloseButton: true,
        cssClass: 'bg-profile',
        message: 'Your Data was Edited!',
        duration: 3000,
        position: 'bottom'
      });

      toast.present();
      this.navCtrl.navigateForward('/home-results');
    });
  }

  getKabKota() {}
}
