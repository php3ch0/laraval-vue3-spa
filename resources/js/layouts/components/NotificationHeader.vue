<template>
  <div id="NotificationHeader">
    <div class="container" :class="[{'text-center': (align==='center')},'text-left']">
      <SettingText name="STATUS_TEXT" />
    </div>

  </div>

</template>

<script>
import SettingText from "../../components/SettingText";
export default {
  name: "NotificationHeader",
  components: {SettingText},
  props: {
    align:String
  }
}
</script>
