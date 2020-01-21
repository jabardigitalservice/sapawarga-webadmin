import { shallowMount, createLocalVue } from "@vue/test-utils"
import AttachmentFileUpload from "@/components/AttachmentFileUpload"
import ElementUI from "element-ui";
import i18n from '@/lang'

const localVue = createLocalVue()
localVue.use(ElementUI)
localVue.use(i18n)

describe('AttachmentFileUpload.vue', () => {
  it('should receive and render props correctly', () => {
    const propsFileUpload = {
      "filePath": null,
      "initialUrl": null,
      "limitFile": 1,
      "type": "photo",
      "typeFile": ".jpg, jpeg",
      "description": "Maximum upload file size: 5 Mb.",
    }
    const wrapper = shallowMount(AttachmentFileUpload, {
      localVue,
      i18n,
      propsData: propsFileUpload,
    })
    expect(wrapper.props()).toEqual(propsFileUpload)
  })
})
