import { TestBed } from '@angular/core/testing';

import { NomorPentingService } from './nomor-penting.service';

describe('NomorPentingService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: NomorPentingService = TestBed.get(NomorPentingService);
    expect(service).toBeTruthy();
  });
});
