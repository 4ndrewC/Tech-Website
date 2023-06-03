# from office365.runtime.auth.authentication_context import AuthenticationContext
# from office365.sharepoint.client_context import ClientContext
# from office365.sharepoint.files.file import File 



# app_settings = {
#      'url': 'https://bssgj-my.sharepoint.com',
#      'client_id': 'd41da8fb-3c1a-4c2a-823d-761050290d9e',
#      'client_secret': 'bsE8Q~o6jBj.t6kA5KS-5N2DBnKgREWsoVhjNcOe'
# }

# ctx_auth = AuthenticationContext(url=app_settings['url'])
# ctx_auth.acquire_token_for_app(client_id=app_settings['client_id'], client_secret=app_settings['client_secret'])

# ctx = ClientContext(app_settings['url'], ctx_auth)

# path = "/www/wwwroot/jc2/Basis-Tech-Website"
# response = File.open_binary(ctx, "/:x:/g/personal/techtools-bisz_basischina_com/ETaBRHBW0kFPodt-EzGZY6sByZb_Sz8BsZama3Gy1RGTBg?rtime=WT7xnJ0j20g.xlsx")
# response.raise_for_status()
# with open(path, "wb") as local_file:
#     local_file.write(response.content)

# print('f')

from office365.runtime.auth.authentication_context import AuthenticationContext
from office365.sharepoint.client_context import ClientContext

# Set the SharePoint site URL and file path
site_url = "https://bssgj-my.sharepoint.com/"
file_path = ":x:/g/personal/techtools-bisz_basischina_com/ETaBRHBW0kFPodt-EzGZY6sByZb_Sz8BsZama3Gy1RGTBg?e=rggt7Z"

# Set the authentication context
auth_ctx = AuthenticationContext(url=site_url)
auth_ctx.acquire_token_for_user("techtools-bisz@basischina.com", "BIS-CTechTools2023")

# Set the client context and download the file
ctx = ClientContext(site_url, auth_ctx)


# Write the file content to a local file
with open("/www/wwwroot/jc2/Basis-Tech-Website/test.xlsx", "wb") as f:
    response = ctx.web.get_file_by_server_relative_url(file_path).download(f)

    f.write(response.content)


#use microsoft api to download sharepoint files 
