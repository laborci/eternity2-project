import ListPreprocessPlugin from "../codex-plugin/types/ListPreprocessPlugin";

@ListPreprocessPlugin.register()
export default class UserListPreprocess2 extends ListPreprocessPlugin {

	static preprocess(row) {
		console.log(row.roles);
		if (row.roles instanceof Array && row.roles.includes('admin')) row.userType = '<i class="fas fa-user-crown"></i>';
		else  if (row.status === 'active') row.userType = '<i class="fas fa-user"></i>';
		else  row.userType = '<i class="fal fa-user"></i>';
	}

}
