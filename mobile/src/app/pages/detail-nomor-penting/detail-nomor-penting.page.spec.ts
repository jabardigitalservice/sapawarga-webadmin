import { CUSTOM_ELEMENTS_SCHEMA } from '@angular/core';
import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { DetailNomorPentingPage } from './detail-nomor-penting.page';

describe('DetailNomorPentingPage', () => {
  let component: DetailNomorPentingPage;
  let fixture: ComponentFixture<DetailNomorPentingPage>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ DetailNomorPentingPage ],
      schemas: [CUSTOM_ELEMENTS_SCHEMA],
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(DetailNomorPentingPage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
