<template>
  <div class="app-container">
    <p class="warn-content">Profile Admin</p>
    <el-row :gutter="10">
      <el-col class="col-left" :xs="24" :sm="24" :md="24" :lg="7" :xl="7">
        <PhotoBox class="image" :image="imageUrl" :height="height"/>
        <p class="warn-content map-title">Lokasi Anda</p>
        <div class="mapouter">
          <div class="gmap_canvas">
            <iframe
              id="gmap_canvas"
              :src="`https://maps.google.com/maps?q=${latitude},${longitude}&t=&z=16&ie=UTF8&iwloc=&output=embed`"
              frameborder="0"
              scrolling="no"
              marginheight="0"
              marginwidth="0"
            ></iframe>
          </div>
        </div>
      </el-col>
      <el-col class="col-right" :xs="24" :sm="24" :md="24" :lg="17" :xl="17">
          <el-table stripe :data="tableData" :show-header="false" border style="width: 100%">
            <el-table-column prop="title" width="180"/>
            <el-table-column prop="content"/>
          </el-table>
          <div class="social-media">
            <p class="warn-content">Media Sosial</p>
            <el-table stripe :data="twitterIcon" :show-header="false" border style="width: 100%">
              <el-table-column width="180">
                <a :href="`https://twitter.com/${twitterAccount}`" target="_blank">
                  <img class="social-media-admin twitter" :src="twitter" align="middle">
                </a>
              </el-table-column>
              <el-table-column prop="content"/>
            </el-table>
            <el-table stripe :data="instagramIcon" :show-header="false" border style="width: 100%">
              <el-table-column width="180">
                <a :href="`https://www.instagram.com/${instagramAccount}`" target="_blank">
                  <img class="social-media-admin twitter" :src="instagram">
                </a>
              </el-table-column>
              <el-table-column prop="content"/>
            </el-table>
            <el-table stripe :data="facebookIcon" :show-header="false" border style="width: 100%">
              <el-table-column width="180">
                <a :href="`${facebookAccount}`" target="_blank">
                  <img class="social-media-admin twitter" :src="facebook">
                </a>
              </el-table-column>
              <el-table-column prop="content"/>
            </el-table>
          </div>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import PhotoBox from "@/components/PhotoBox";
import { getInfo } from "@/api/user";

export default {
  components: { PhotoBox },
  data() {
    return {
      id: 0,
      imageUrl: null,
      height: "220px",
      tableData: [],
      instagramIcon: [],
      twitterIcon: [],
      facebookIcon: [],
      urlMap: null,
      latitude: null,
      longitude: null,
      twitter: require("@/assets/twitter.svg"),
      facebook: require("@/assets/facebook.svg"),
      instagram: require("@/assets/instagram.svg"),
      twitterAccount: null,
      facebookAccount: null,
      instagramAccount: null
    };
  },

  created() {
    this.getDetail();
  },

  methods: {
    getDetail() {
      getInfo().then(response => {
        const {
          name,
          address,
          kabkota,
          kecamatan,
          kelurahan,
          phone,
          lat,
          lon,
          photo_url,
          email,
          facebook,
          instagram,
          rt,
          rw,
          twitter,
          username,
          role_label
        } = response.data;
        this.twitterAccount = twitter || "-";
        this.facebookAccount = facebook || "-";
        this.instagramAccount = instagram || "-";
        this.imageUrl = photo_url !== null ? photo_url : null;
        this.latitude = lat;
        this.longitude = lon;
        this.instagramIcon = [
          {
            content: ": " + (instagram !== null ? instagram : '-')
          }
        ]
        this.twitterIcon = [
          {
            content: ": " + (twitter !== null ? twitter : '-')
          }
        ]
        this.facebookIcon = [
          {
            content: ": " + (facebook !== null ? facebook : '-')
          }
        ]
        this.tableData = [
          {
            title: "Nama",
            content: ": " + (name !== null ? name : "-")
          },
          {
            title: "Username",
            content: ": " + (username !== null ? username : "-")
          },
          {
            title: "Email",
            content: ": " + (email !== null ? email : "-")
          },
          {
            title: "Telepon",
            content: ": " + (phone !== null ? phone : "-")
          },
          {
            title: "Alamat Instansi",
            content: ": " + (address !== null ? address : "-")
          },
          {
            title: "RT",
            content: ": " + (rt !== null ? rw : "-")
          },
          {
            title: "RW",
            content: ": " + (rw !== null ? rw : "-")
          },
          {
            title: "Kelurahan",
            content: ": " + (kelurahan !== null ? kelurahan.name : "-")
          },
          {
            title: "Kecamatan",
            content: ": " + (kecamatan !== null ? kecamatan.name : "-")
          },
          {
            title: "Kab/Kota",
            content: ": " + (kabkota !== null ? kabkota.name : "-")
          },
          {
            title: "Peran",
            content: ": " + (role_label !== null ? role_label : "-")
          },
        ];
      });
    }
  }
};
</script>

<style lang="scss" scoped>
.map {
  margin-top: 50px;
  height: 50px;
  width: 270px;
}

.mapouter {
    position: relative;
    text-align: right;
    height: 350px;
    width: 400px;
  }
  .gmap_canvas {
    background: none !important;
    width: 400px;
    height: 350px;
    margin-left: 20px;
    border-radius: 5px;
    margin-top: 20px;
    -webkit-box-shadow: 0px 0px 25px -10px rgba(0, 0, 0, 0.75);
    -moz-box-shadow: 0px 0px 25px -10px rgba(0, 0, 0, 0.75);
    box-shadow: 0px 0px 25px -10px rgba(0, 0, 0, 0.75);

    iframe {
      width: 400px;
      height: 350px;
    }
  }

.warn-content {
  // color: #909399;
  // background-color: #dcdfe6;
}

.map-title {
  width: 400px;
  margin-left: 20px;
  margin-bottom: 10px;
  margin-top: 50px;
  padding: 10px;
}

.social-media-admin {
  width: 30px;
  height: 30px;
  display: block;
  margin-left: 40%;
}

.social-media-card {
  margin-top: 30px;
}

@media only screen and (max-width: 1200px) {
  .col-right {
    margin-top: 30px;
    margin-left: 20px;
    padding-right: 30px !important;
  }

}

@media only screen and (min-width: 1200px) and (max-width: 1570px) {
  .gmap_canvas {
    background: none !important;
    width: 250px;
    height: 230px;
    margin-left: 20px;
    border-radius: 5px;
    margin-top: 20px;
    -webkit-box-shadow: 0px 0px 25px -10px rgba(0, 0, 0, 0.75);
    -moz-box-shadow: 0px 0px 25px -10px rgba(0, 0, 0, 0.75);
    box-shadow: 0px 0px 25px -10px rgba(0, 0, 0, 0.75);
    iframe {
      width: 250px;
      height: 230px;
    }
  }

  .map-title {
    width: 250px;
    margin-left: 20px;
    margin-bottom: 10px;
    margin-top: 50px;
    padding: 10px;
  }
}
</style>
