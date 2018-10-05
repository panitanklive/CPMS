import { Component, OnInit } from "@angular/core";
import { HttpClient } from "@angular/common/http";
import { Router } from "@angular/router";
import { Location } from "@angular/common";
import { ActivatedRoute } from "@angular/router";
import { CookieService } from "ngx-cookie-service";
import swal from "sweetalert2";
import { UrlService } from "../url.service";

@Component({
  selector: "app-addcar",
  templateUrl: "./addcar.component.html",
  styleUrls: ["./addcar.component.css"]
})
export class AddcarComponent implements OnInit {
  car_brand = [
    { brand: "Bmw" },
    { brand: "Chevrolet" },
    { brand: "Ford" },
    { brand: "Honda" },
    { brand: "Isuzu" },
    { brand: "Mazda" },
    { brand: "Mercedez-Benz" },
    { brand: "Mitsubish" },
    { brand: "Nissan" },
    { brand: "Subaru" },
    { brand: "Suzuki" },
    { brand: "Toyota" }
  ];
  park = [
    { carpool_park: "อาคาร 1" },
    { carpool_park: "อาคาร 2" },
    { carpool_park: "อาคาร 3 Scarda" },
    { carpool_park: "อาคาร 5" },
    { carpool_park: "อาคาร 6" },
    { carpool_park: "ลานกว้าง" },
    { carpool_park: "ลานอเนกประสงค์" },
    { carpool_park: "โรงอาหาร" },
    { carpool_park: "สถานีไฟฟ้า" }
  ];

  urlbase: string;
  carpool_id = "";
  carpool_brand = "";
  carpool_model = "";
  carpool_type = "";
  carpool_sit2 = 4;
  carpool_mile = "";
  get: any;
  carpool_park: string;
  constructor(
    private http: HttpClient,
    private router: Router,
    private location: Location,
    public service: UrlService,
    private activatedRoute: ActivatedRoute,
    private cookie: CookieService
  ) {
    this.urlbase = service.get_url();
    this.service.nav = "car";
  }

  ngOnInit() {}

  add() {
    if (this.carpool_id == "") {
      swal("ทะเบียนรถ", "กรุณากรอกทะเบียนรถใหม่", "warning");
    } else if (this.carpool_brand == "") {
      swal("ยี่ห้อ", "กรุณากรอกยี่ห้อรถ", "warning");
    } else if (this.carpool_model == "") {
      swal("รุ่น", "กรุณากรอกรุ่นรถ", "warning");
    } else if (this.carpool_type == "") {
      swal("ประเภทรถ", "กรุณากรอกประเภทรถ", "warning");
    } else if (this.carpool_sit2 <= 0) {
      swal("จำนวนที่นั่งสูงสุด", "กรุณากรอกที่นั่งสูงสุด", "warning");
    } else if (this.carpool_mile.length != 6) {
      swal("ไมล์รถ", "กรุณากรอกไมล์รถ", "warning");
    } else if (this.carpool_park == "") {
      swal("สถานที่จอดรถ", "กรุณากรอกสถานที่จอดรถ", "warning");
    } else {
      let creds = JSON.stringify({
        carpool_id: this.carpool_id,
        carpool_brand: this.carpool_brand,
        carpool_model: this.carpool_model,
        carpool_type: this.carpool_type,
        carpool_sit2: this.carpool_sit2,
        carpool_mile: this.carpool_mile,
        carpool_parl: this.carpool_park,
        btnName: "เพิ่ม"
      });
      this.http
        .post(this.urlbase + "myconn/car/insert_car.php", creds, {
          responseType: "text"
        })
        .subscribe(data => {
          this.get = data;
          if (this.get == 1) {
            swal(
              "เรียบร้อย",
              "เพิ่ม " + this.carpool_id + " เรียบร้อยแล้ว",
              "success"
            );
            this.router.navigate(["chem"]);
          } else {
            swal(
              "เกิดปัญหาปัญหา",
              "ไม่สามารถเพิ่ม" + " " + this.carpool_id + " ได้",
              "error"
            );
          }
        });
    }
  }
}
