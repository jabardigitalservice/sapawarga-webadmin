import { shallowMount, createLocalVue } from "@vue/test-utils"
import AttachmentFileUpload from "@/components/AttachmentFileUpload"
import ElementUI from "element-ui";

const localVue = createLocalVue()
localVue.use(ElementUI)

describe('AttachmentFileUpload.vue', () => {
  it('should receive and render props correctly', () => {
    const propsFileUpload = {
      "filePath": null,
      "initialUrl": null,
      "limitFile": 1,
      "listInformation": [],
      "type": "photo",
      "typeFile": ".jpg, jpeg",
    }
    const wrapper = shallowMount(AttachmentFileUpload, {
      localVue,
      propsData: propsFileUpload,
    })
    expect(wrapper.props()).toEqual(propsFileUpload)
  })
})
